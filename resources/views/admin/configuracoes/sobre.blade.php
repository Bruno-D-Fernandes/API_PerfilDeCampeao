@extends('admin.config.layout')

@section('content')
<div class="corpoSobre">
  
  <h2>Sobre</h2>
  <h3>Sistema</h3>
  <div class="logoSobre">
  <img src="{{asset('/img/logo-admin-reduzida.jpeg')}}" class="logo" alt="">
  </div>
  <h6>Perfil de Campeão</h6>
  <h6>Versão 1.0 (TCC)</h6>

  <h3>Desenvolvedores</h3>
  <div class="listaDev">
  <ul id="devList">
    <li>Adriel</li>
    <li>Bruno</li>
    <li>Gustavo</li>
    <li>João</li>
    <li>Kauã</li>
    <li>Leticia</li>
    <li>Luan</li>
    <li>Marcos Vinícius</li>
    <li>Maria Clara</li>
    <li>Vitor Augusto</li>
  </ul>
</div class='politica'>
  <p class='nada'>Política de privicidade</p>
  <p class='nada'>Termos e Condições</p>
  <p class='nada'>Relatar um problema</p>
  </div>
@endsection
