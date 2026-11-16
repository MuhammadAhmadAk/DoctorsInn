<?php

namespace Tests\Feature;

use App\Models\MockTest;
use App\Models\TestAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MockTestTest extends TestCase
{
    use RefreshDatabase;

    protected function makeTest(): MockTest
    {
        $test = MockTest::create([
            'slug' => 'mdcat-bio-1',
            'title' => 'MDCAT Biology 1',
            'category' => 'mdcat',
            'category_name' => 'MDCAT',
            'duration_minutes' => 30,
            'total_questions' => 0,
            'marks_per_question' => 1,
            'passing_percentage' => 50,
            'is_active' => true,
        ]);

        foreach (['A', 'B', 'C', 'D'] as $i => $correct) {
            $test->questionBank()->create([
                'subject' => $i < 2 ? 'Biology' : 'Chemistry',
                'question' => "Question {$i}?",
                'options' => ['A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd'],
                'correct_option' => $correct,
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }

        return $test;
    }

    protected function admin(array $permissions = [], string $role = 'admin'): array
    {
        $user = User::factory()->create(['role' => $role, 'permissions' => $permissions]);

        return ['admin_user' => ['email' => $user->email, 'role_key' => $role, 'permissions' => $permissions]];
    }

    public function test_submission_is_scored_and_stored(): void
    {
        $test = $this->makeTest();
        $student = User::factory()->create(['role' => 'student']);
        $ids = $test->questionBank->pluck('id')->all();

        $response = $this->actingAs($student)->post(route('test.submit', $test->slug), [
            'answers' => [$ids[0] => 'A', $ids[1] => 'B', $ids[2] => 'A'],
            'time_spent_seconds' => 120,
        ]);

        $attempt = TestAttempt::firstOrFail();
        $response->assertRedirect(route('test.result', $attempt->id));

        $this->assertSame(2, (int) $attempt->correct_count);
        $this->assertSame(1, (int) $attempt->incorrect_count);
        $this->assertSame(1, (int) $attempt->skipped_count);
        $this->assertEquals(50, $attempt->percentage);
        $this->assertTrue((bool) $attempt->passed);
        $this->assertSame($test->id, $attempt->mock_test_id);
    }

    public function test_inactive_questions_are_not_served(): void
    {
        $test = $this->makeTest();
        $test->questionBank()->first()->update(['is_active' => false]);

        $this->assertCount(3, $test->fresh()->toFrontendArray()['questions']);
    }

    public function test_admin_can_add_update_and_delete_mcq(): void
    {
        $test = $this->makeTest();
        $session = $this->admin();

        $payload = [
            'subject' => 'Physics',
            'question' => 'Unit of force?',
            'options' => ['A' => 'Newton', 'B' => 'Joule', 'C' => 'Watt', 'D' => 'Pascal'],
            'correct_option' => 'A',
        ];

        $this->withSession($session)
            ->post(route('admin.tests.questions.store', $test->slug), $payload)
            ->assertRedirect(route('admin.tests.questions', $test->slug));

        $question = $test->questionBank()->where('subject', 'Physics')->firstOrFail();
        $this->assertSame(5, (int) $test->fresh()->total_questions);

        $this->withSession($session)
            ->put(route('admin.tests.questions.update', [$test->slug, $question->id]), array_merge($payload, ['correct_option' => 'B']))
            ->assertRedirect();
        $this->assertSame('B', $question->fresh()->correct_option);

        $this->withSession($session)
            ->delete(route('admin.tests.questions.destroy', [$test->slug, $question->id]))
            ->assertRedirect();
        $this->assertNull($question->fresh());
    }

    public function test_mcq_requires_four_options_and_valid_answer(): void
    {
        $test = $this->makeTest();

        $this->withSession($this->admin())
            ->post(route('admin.tests.questions.store', $test->slug), [
                'question' => 'Incomplete?',
                'options' => ['A' => 'x', 'B' => 'y'],
                'correct_option' => 'E',
            ])
            ->assertSessionHasErrors(['options.C', 'options.D', 'correct_option']);
    }

    public function test_staff_without_tests_permission_is_blocked(): void
    {
        $test = $this->makeTest();

        $this->withSession($this->admin(['students'], 'staff'))
            ->get(route('admin.tests.questions', $test->slug))
            ->assertRedirect(route('admin.dashboard'));
    }
}
