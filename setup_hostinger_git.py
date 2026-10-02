import paramiko
host = '46.202.196.107'
port = 65002
username = 'u938080869'
key_filename = r'C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger'

commands = [
    "rm -rf /home/u938080869/domains/doctorsinnelite.com/git_dev.git",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && rm -rf .git",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git init",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git remote add origin https://github.com/MuhammadAhmadAk/DoctorsInn.git",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git fetch origin",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git reset --hard origin/main",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git branch -M main",
    "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git branch --set-upstream-to=origin/main main"
]

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, port, username, key_filename=key_filename)
for cmd in commands:
    stdin, stdout, stderr = ssh.exec_command(cmd)
    stdout.channel.recv_exit_status()
ssh.close()
print("Done")
