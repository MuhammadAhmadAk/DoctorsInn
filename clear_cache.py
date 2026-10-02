import paramiko
host = '46.202.196.107'
port = 65002
username = 'u938080869'
key_filename = r'C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, port, username, key_filename=key_filename)
stdin, stdout, stderr = ssh.exec_command('cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && php artisan optimize:clear')
print(stdout.read().decode())
print(stderr.read().decode())
ssh.close()
