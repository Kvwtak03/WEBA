<h2 class="mb-4">Seznam uživatelů z REST API</h2>
<p class="text-muted">Tato data pocházejí z odděleného zdroje a načítají se asynchronně na pozadí.</p>

<!-- Tlačítko, které odstartuje AJAX požadavek -->
<button id="btnLoadApiUsers" class="btn btn-primary mb-4">
    <i class="bi bi-cloud-download"></i> Načíst data přes AJAX
</button>

<!-- Kontejner pro zobrazení dat. Zpočátku je prázdný. -->
<div class="card shadow-sm" style="max-width: 600px;">
    <ul id="apiUsersList" class="list-group list-group-flush">
        <li class="list-group-item text-center text-muted py-4">
            Klikněte na tlačítko pro stažení dat.
        </li>
    </ul>
</div>


<hr class="my-5">

<h2 class="mb-4">React Komponenta: Panel s tlačítky</h2>
<!-- ZÁCHYTNÝ BOD PRO REACT: Sem ReactDOM.createRoot() vstříkne naši aplikaci -->
<div id="root"></div>