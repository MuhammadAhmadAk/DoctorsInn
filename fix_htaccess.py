import paramiko
host = '46.202.196.107'
port = 65002
username = 'u938080869'
key_filename = r'C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger'

htaccess_content = """<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
"""

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, port, username, key_filename=key_filename)
sftp = ssh.open_sftp()
with sftp.file('/home/u938080869/domains/doctorsinnelite.com/public_html/dev/.htaccess', 'w') as f:
    f.write(htaccess_content)
sftp.close()
ssh.close()
