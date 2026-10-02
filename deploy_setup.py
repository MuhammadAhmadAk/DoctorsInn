import paramiko
import traceback

host = '46.202.196.107'
port = 65002
username = 'u938080869'
password = '7ujP!We|3Gj'

pub_key = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC0ji9nbDvr/+jSxmfzl1zTy5qUb64rikH6BcKETtvSzVfa9WIKkQtbKYKjYZdHtmPPYfQ6EbSqlp8W/PBvzb/PlIAh17qU6XJZqWJmaY0denR9N9eD77fxL13S32pQYFFIGqZclQLqJe9G+APhqG72N+myDyzFgTWrIurFmmjCJqF12VLGLQ2LLTET8PUT2IHLz7ULXcqHnb+xQxq+nbEHmDtttKMAJCx7MGEWtbvU4MB4AfXHSBqx0ZzgkZy8g1CheTTaTUpmlccAlWED4a3tz+Y5IsY7PNHmsCSCivf1uWqrf7UER47JytZHt7QH5Hjz7neEZCBUYCN1bkuNoRZh deployment"

try:
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    print("Connecting to server...")
    ssh.connect(host, port, username, password, timeout=10)
    print("Connected!")
    
    commands = [
        "mkdir -p ~/.ssh",
        "chmod 700 ~/.ssh",
        f"echo '{pub_key}' >> ~/.ssh/authorized_keys",
        "chmod 600 ~/.ssh/authorized_keys",
        "mkdir -p ~/domains/doctorsinnelite.com/git_dev.git",
        "cd ~/domains/doctorsinnelite.com/git_dev.git && git init --bare",
        "cat << 'EOF' > ~/domains/doctorsinnelite.com/git_dev.git/hooks/post-receive\n#!/bin/bash\nTARGET=\"/home/u938080869/domains/doctorsinnelite.com/public_html/dev\"\nGIT_DIR=\"/home/u938080869/domains/doctorsinnelite.com/git_dev.git\"\nBRANCH=\"master\"\nwhile read oldrev newrev ref\ndo\n    if [[ $ref = refs/heads/$BRANCH ]]; then\n        echo \"Ref $ref received. Deploying master branch to dev folder...\"\n        git --work-tree=\"$TARGET\" --git-dir=\"$GIT_DIR\" checkout -f\n        cd \"$TARGET\"\n        # If you need composer install, you can add it here\n    else\n        echo \"Ref $ref received. Doing nothing: only the master branch may be deployed on this server.\"\n    fi\ndone\nEOF\n",
        "chmod +x ~/domains/doctorsinnelite.com/git_dev.git/hooks/post-receive"
    ]
    
    for cmd in commands:
        stdin, stdout, stderr = ssh.exec_command(cmd)
        exit_status = stdout.channel.recv_exit_status()          # Blocking call
        out = stdout.read().decode('utf-8').strip()
        err = stderr.read().decode('utf-8').strip()
        if out: print(f"OUT: {out}")
        if err: print(f"ERR: {err}")
    
    ssh.close()
    print("Setup completed successfully.")
except Exception as e:
    print("Error:", str(e))
    traceback.print_exc()
