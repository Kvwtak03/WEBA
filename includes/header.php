<!doctype html>
<html lang="en">

<head>
  <title>Simple Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./css/custom.css">
</head>

<style>
  /* some hacks for responsive sidebar */
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    /* height of navbar */
  }

  .sidebar-sticky {
    height: calc(100vh - 48px);
    overflow-x: hidden;
    overflow-y: auto;
  }
</style>

<body>

    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow " >
        <button class="navbar-toggler d-md-none collapsed m-2 b-0" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">simple administration</a>

        <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="?url=logout">logout</a>
        </div>
        </div>
    </header>
    <div class="container-fluid">
    <div class="row">