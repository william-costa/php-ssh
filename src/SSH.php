<?php

namespace WilliamCosta\SecureShell;

class SSH{

  /**
   * Instância do recurso de conexão
   * @var resource
   */
  private $connection;

  /**
   * Método responsável por iniciar a conexão SSH
   * @param  string  $host
   * @param  integer $port
   * @return boolean
   */
  public function connect($host,$port){
    //NOVA CONEXÃO
    $this->connection = ssh2_connect($host,$port);

    //RETORNA O SUCESSO
    return $this->connection ? true : false;
  }

  /**
   * Método responsável por autenticar a conexão utilizando usuário e senha
   * @param  string $user
   * @param  string $pass
   * @return boolean
   */
  public function authPassword($user,$pass){
    return $this->connection ? ssh2_auth_password($this->connection,$user,$pass) : false;
  }

  /**
   * Método responsável por autenticar a conexão utilizando par de chaves SSH
   * @param  string $user
   * @param  string $publicKey
   * @param  string $privateKey
   * @param  string $passphrase
   * @return boolean
   */
  public function authPublicKeyFile($user,$publicKey,$privateKey,$passphrase = null){
    return $this->connection ? ssh2_auth_pubkey_file($this->connection,$user,$publicKey,$privateKey,$passphrase) : false;
  }

  /**
   * Método responsável por remover a conexão atual
   * @return boolean
   */
  public function disconnect(){
    //DESCONECTA
    if($this->connection) ssh2_disconnect($this->connection);

    //LIMPA A CLASSE
    $this->connection = null;

    //SUCESSO
    return true;
  }

  /**
   * Método responsável por obter uma saída de uma stream
   * @param  resource $stream
   * @param  integer  $id
   * @return string
   */
  private function getOutput($stream,$id){
    //STREAM DA SAÍDA
    $streamOut = ssh2_fetch_stream($stream,$id);

    //CONTEÚDO DA SAÍDA
    return stream_get_contents($streamOut);
  }

  /**
   * Método responsável por executar comandos SSH
   * @param  string $command
   * @param  string $stdErr
   * @return string
   */
  public function exec($command,&$stdErr = null){
    //VERIFICA A CONEXÃO
    if(!$this->connection) return null;

    //EXECUTA O COMANDO SSH
    if(!$stream = ssh2_exec($this->connection,$command)){
      return null;
    }

    //BLOQUEIA A STREAM
    stream_set_blocking($stream,true);

    //SAÍDA STDIO
    $stdIo = $this->getOutput($stream,SSH2_STREAM_STDIO);

    //SAÍDA STDERR
    $stdErr = $this->getOutput($stream,SSH2_STREAM_STDERR);

    //DESBLOQUEIA A STREAM
    stream_set_blocking($stream,false);

    //RETORNA O STDIO
    return $stdIo;
  }
}