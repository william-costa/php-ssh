# PHP SSH

Simples gerenciador de conexões SSH em PHP utilizando a lib SSH2

## Instalação

Para instalar esta dependência basta executar o comando abaixo:
```shell
composer require william-costa/php-ssh
```

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

//AUTENTICAÇÃO VIA USUÁRIO E SENHA
if(!$obSSH->authPassword('wdev','123456')){
  die('Autenticação falhou');
}

//AUTENTICAÇÃO VIA PAR DE CHAVES
if(!$obSSH->authPublicKeyFile('wdev','chave_rsa.pub','chave_rsa.pem')){
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
- Necessário ter a lib SSH2 instalada e ativa