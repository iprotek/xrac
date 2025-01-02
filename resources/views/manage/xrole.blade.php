@extends('iprotek_core::layout.pages.view-dashboard')

@section('logout-link','/logout')
@section('site-title', 'ROLE DEFAULTS')
@section('head') 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!--
    <link rel="stylesheet" href="/css/icons.css">
-->
@endsection
@section('breadcrumb')
    <!--
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Widgets</li>
    -->
@endsection
@section('content') 
  <div id="main-content"> 
    <xrole-index />
  </div> 
@endsection

@section('foot') 
  <script>
    ActivateMenu(['menu-user-roles']);
  </script>  
  <script src="/iprotek/js/manage/xrac/xrole.js"> </script>
@endsection

