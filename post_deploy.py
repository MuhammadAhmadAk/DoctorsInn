import paramiko
import traceback
import os

host = '46.202.196.107'
port = 65002
username = 'u938080869'
key_filename = r'C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger'

try:
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(host, port, username, key_filename=key_filename)
    
    # Upload .env
    sftp = ssh.open_sftp()
    local_env = r'C:\xampp\htdocs\DoctorsInn\.env'
    remote_env = '/home/u938080869/domains/doctorsinnelite.com/public_html/dev/.env'
    if os.path.exists(local_env):
        sftp.put(local_env, remote_env)
        print(".env uploaded.")
    sftp.close()
    
    # Run composer install
    commands = [
        "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && composer install --no-dev --optimize-autoloader",
        "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && php artisan optimize:clear"
    ]
    
    for cmd in commands:
        print(f"Running: {cmd}")
        stdin, stdout, stderr = ssh.exec_command(cmd)
        exit_status = stdout.channel.recv_exit_status()
        out = stdout.read().decode('utf-8').strip()
        err = stderr.read().decode('utf-8').strip()
        if out: print(f"OUT: {out}")
        if err: print(f"ERR: {err}")
    
    ssh.close()
    print("Post-deploy setup completed.")
except Exception as e:
    print("Error:", str(e))
    traceback.print_exc()
