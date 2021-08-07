# PHP SSH

Simples gerenciador de conexões SSH em PHP utilizando a lib SSH2

## Utilização

Para usar este gerenciador basta seguir o exemplo abaixo:
```php
<?php
require __DIR__.'/vendor/autoload.php';

//DEPENDÊNCIAS
use WilliamCosta\SecureShell\SSH;

//INSTÂNCIA
$obSSH = new SSH;

//CONEXÃO
if(!$obSSH->connect('172.17.0.1',2222)){
  die('Conexão falhou');
}

//AUTENTICAÇÃO
if(!$obSSH->authPassword('wdev','123456')){
  die('Autenticação falhou');
}

//EXECUTA COMANDOS
$stdIo = $obSSH->exec('ls -l',$stdErr);
echo "STDERR:\n".$stdErr;
echo "STDIO:\n".$stdIo;

//DESCONECTA
$obSSH->disconnect();
```

## Requisitos
- Necessário PHP 7.0 ou superior