<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurssien hallinta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    :root {
        --bg: #ffffff;
        --surface: #f7f9fb;
        --primary: #aa0000;
        --accent: #dd0000;
        --text: #b90000;
        --muted: #6b7785;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: var(--bg);
        color: var(--text);
    }

    header {
        background: linear-gradient(90deg, var(--primary), #12365a);
        color: #fff;
        padding: 16px 24px;
    }

    header a {
        color: rgba(255, 255, 255, 0.95);
        text-decoration: none;
        margin-right: 12px;
    }

    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 8px;
    }

    main {
        padding: 24px;
        background: var(--surface);
        min-height: calc(100vh - 140px);
    }

    footer {
        padding: 12px 24px;
        color: var(--muted);
        font-size: 0.9rem;
    }

    button {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background: var(--accent);
    }
</style>

<body>
    <header>
        <h1>Kurssien hallinta</h1>
        <nav>
            <a href="kurssienhallinta.html">Etusivu</a> |
            <a href="ilmoittautumiset.html">Ilmoittautumiset</a> |
            <a href="tilat.html">Tilat</a> |
            <a href="opettajat.html">Opettajat</a> |
            <a href="opiskelijat.html">Opiskelijat</a>

        </nav>
    </header>
    <main>
        <section class="kurssin-lisays">
            <h2>Lisää uusi kurssi</h2>
            <form id="kurssi-lomake">
                <div>
                    <label for="kurssi-nimi">Kurssin nimi:</label>
                    <input type="text" id="kurssi-nimi" required>
                </div>
                <div>
                    <label for="opettaja">Valitse opettaja:</label>
                    <select id="opettaja" required>
                        <option value="">Valitse opettaja</option>
                        <option value="">Matti, Virtanen, Matematiikka</option>
                        <option value="">Liisa, Korhonen, Ohjelmointi</option>
                        <option value="">Pekka, Nieminen, Fysiikka</option>
                        <option value="">Anna, Mäkinen, Kemia</option>
                        <option value="">Juha, Lehtonen, Tietotekniikka</option>
                        <option value="">Riitta, Palmunen, Kuvataide</option>
                        <option value="">Juhana, Järvinen, Äidinkieli ja kirjallisuus</option>
                        <option value="">Asta, Järvinen, Yhteiskuntaoppi</option>
                        <option value="">Alina, Virtanen, Ruotsi</option>
                        <option value="">Heidi, Järvinen, Äidinkieli ja kirjallisuus</option>
                        <option value="">Riitta, Palmunen, Historia</option>
                        <option value="">Karita, Järvinen, Englanti</option>
                        <option value="">Ari, Roos, Englanti</option>
                        <option value="">Riitta, Palmunen, Kuvataide</option>
                        <option value="">Minna, Lappalainen, Käsityö</option>
                        <option value="">Karita, Palmunen, Maantieto</option>
                        <option value="">Riitta, Järvi, Uskonto</option>
                        <option value="">Alina, Roos, Uskonto</option>
                        <option value="">Julia, Roos, Liikunta</option>
                        <option value="">Julia, Riihko, Biologia</option>
                    </select>
                </div>
                <div>
                    <label for="tila">Valitse tila:</label>
                    <select id="tila" required>
                        <option value="">Valitse tila</option>
                        <option value="">A101, 30 paikkaa</option>
                        <option value="">A102, 25 paikkaa</option>
                        <option value="">B205, 40 paikkaa</option>
                        <option value="">B206, 20 paikkaa</option>
                        <option value="">C303, 35 paikkaa</option>
                        <option value="">A104, 38 paikkaa</option>
                        <option value="">C308, 50 paikkaa</option>
                        <option value="">E501, 32 paikkaa</option>
                        <option value="">C310, 47 paikkaa</option>
                        <option value="">D401, 19 paikkaa</option>
                        <option value="">D404, 40 paikkaa</option>
                        <option value="">B207, 44 paikkaa</option>
                        <option value="">D406, 50 paikkaa</option>
                        <option value="">D402, 22 paikkaa</option>
                        <option value="">A103, 20 paikkaa</option>


                        </select>
                </div>
                <button type="submit">Tallenna kurssi</button>
            </form>
        </section>

        <section class="kurssien-listaus">
            <h2>Kurssit</h2>
            <table id="kurssit-taulukko">
                <thead>
                    <tr>
                        <th>Kurssin nimi</th>
                        <th>Opettaja</th>
                        <th>Tila</th>
                        <th>Ilmoittautuneet</th>
                        <th>Toiminnot</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Kurssienhallinta</p>
    </footer>
</body>
<script>
const form = document.getElementById('');
const tableBody = document.querySelector('');
function load(){ JSON.parse(localStorage.getItem('')||'[]').forEach(t=> {
    const tr=document.createElement('tr'); tr.innerHTML=`<td>${t.name}</td><td>${t.subject||''}</td><td></td>`; tableBody.append(tr);
});}
form.addEventListener('submit',e=>{ e.preventDefault(); const t={name:document.getElementById('').value,subject:document.getElementById('').value}; const arr=JSON.parse(localStorage.getItem('')||'[]'); arr.push(t); localStorage.setItem('teachers',JSON.stringify(arr)); tableBody.innerHTML=''; load(); form.reset();});
load();
</script>

</html>
