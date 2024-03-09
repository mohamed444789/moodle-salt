**1. Saltstack installieren, Dienste aktivieren und Starten**
```
sudo curl -fsSL -o /etc/apt/keyrings/salt-archive-keyring-2023.gpg https://repo.saltproject.io/salt/py3/ubuntu/22.04/arm64/SALT-PROJECT-GPG-PUBKEY-2023.gpg
echo "deb [signed-by=/etc/apt/keyrings/salt-archive-keyring-2023.gpg arch=arm64] https://repo.saltproject.io/salt/py3/ubuntu/22.04/arm64/latest jammy main" | sudo tee /etc/apt/sources.list.d/salt.list
sudo apt-get update
sudo apt-get install salt-master
sudo apt-get install salt-minion
sudo apt-get install salt-ssh
sudo apt-get install salt-syndic
sudo apt-get install salt-cloud
sudo apt-get install salt-api
sudo systemctl enable salt-master && sudo systemctl start salt-master
sudo systemctl enable salt-minion && sudo systemctl start salt-minion
sudo systemctl enable salt-syndic && sudo systemctl start salt-syndic
sudo systemctl enable salt-api && sudo systemctl start salt-api

```
**2. Saltmaster konfigurieren** <br>
`nano /etc/salt/master.d/network.conf`
```
# The network interface to bind to
interface: 172.31.8.72

# The Request/Reply port
ret_port: 4506

# The port minions bind to for commands, aka the publish port
publish_port: 4505
```

**3. Saltminion konfigurieren** <br>
`nano /etc/salt/minion.d/master.conf`
```
master: 172.31.8.72
```
`nano /etc/salt/minion.d/id.con`
```
id: moodle 
```




**4. Git Repository auf dem Lokalen Rechner klonen** <br>

```
git clone git@github.com:mohamed444789/moodle-salt.git
```


**5. Dateien auf dem Ordner /srv/salt für Saltstack kopieren** <br>

```
cp -r moodle-salt/* /srv/salt
```


**6. Google SuchID,APIkey für Plugin und Email Adresse für Let's Encrypt Zertifikat hinzufügen.** <br>

**7. Moodle mit Saltstack installieren** <br>

```
sudo salt 'moodle' state.apply moodle
```





