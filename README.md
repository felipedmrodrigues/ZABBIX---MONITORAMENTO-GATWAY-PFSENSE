# 🛰️ ZABBIX - MONITORAMENTO DE GATEWAY DO PFSENSE

Este projeto contém:

- `gateway.php`: Script PHP para coleta do status dos gateways no pfSense.
- `zabbix_agentd.conf.exemplo`: Exemplo de configuração do agente Zabbix.
- `Zabbix-Template-PFSense-Gateways.xml`: Template pronto para importar no Zabbix.

---

## ✅ Como configurar o monitoramento

### 🛠️ 1. Pré-requisitos

- Zabbix Server instalado e acessível.
- pfSense com Zabbix Agent instalado.
- Acesso SSH ao pfSense como `root`.

---

### 📦 2. Instalar o script no pfSense

```bash
mkdir -p /scripts
scp gateway.php root@IP_DO_PFSENSE:/scripts/
chmod +x /scripts/gateway.php
```

---

### 🔧 3. Configurar o Zabbix Agent no pfSense

# Adicione o arquivo `/usr/local/etc/zabbix6/zabbix_agentd.conf`:

# No final do arquivo zabbix_agentd.conf você deve especificar qual o nome da interface que utiliza no pfsense de acordo com a sua interface. 

```bash
UserParameter=test.gateway.status.PORTA2,/usr/local/bin/php -q /scripts/gateway.php PORTA2 status
UserParameter=test.gateway.status.PORTA6,/usr/local/bin/php -q /scripts/gateway.php PORTA6 status
UserParameter=test.gateway.status.LAN,/usr/local/bin/php -q /scripts/gateway.php LAN status
```

E reinicie o agente:

```bash
service zabbix_agentd restart
```

---

### ✅ 4. Testar manualmente

```bash
php -q /scripts/gateway.php discovery
php -q /scripts/gateway.php PORTA2 status
```

---

### 📥 5. Importar Template no Zabbix

1. Vá em `Configuration → Templates → Import`.
2. Selecione o arquivo `Zabbix-Template-PFSense-Gateways.xml`.
3. Aplique o template ao host do pfSense.

---

### 📊 6. Opcional: criar Value Mapping

Para facilitar a leitura do status:

1. Vá em `Administration → General → Value mapping`.
2. Crie um novo com os valores:
   - `online` → 🟢 Online
   - `down` → 🔴 Offline

---

## 🙌 Pronto!

Seu Zabbix agora monitora o status dos gateways do pfSense com base em `latência`, `perda`, `descrição` e `status atual`.

---

Feito com 💻 por [felipedmrodrigues](https://github.com/felipedmrodrigues)
