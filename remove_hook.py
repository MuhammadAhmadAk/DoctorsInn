import paramiko
host = '46.202.196.107'
port = 65002
username = 'u938080869'
key_filename = r'C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, port, username, key_filename=key_filename)
ssh.exec_command('rm -f /home/u938080869/domains/doctorsinnelite.com/git_dev.git/hooks/post-receive')
ssh.close()
