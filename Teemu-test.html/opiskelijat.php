<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Opiskelijat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    :root {
        --bg: #ffffff;
        --surface: #f7f9fb;
        --primary: #e20000;
        --accent: #fd0d0d;
        --text: #bb0000;
        --muted: #856b6b;
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
        background: linear-gradient(90deg, var(--primary), #af0000);
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
        <h1>Opiskelijat</h1>
        <nav>
            <a href="kurssienhallinta.html">Etusivu</a> |
            <a href="kurssit.html">Kurssit</a> |
            <a href="opettajat.html">Opettajat</a> |
            <a href="tilat.html">Tilat</a> |
            <a href="ilmoittautumiset.html">Ilmoittautumiset</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Opiskelijat</h2>
            <form id="opiskelija-form">
                <ul>Eetu, Saarinen, 2006-03-15, 1</ul>
                <ul>Emma, Virtanen, 2005-07-22, 2</ul>
                <ul>Mikko, Korhonen, 2004-11-08, 3</ul>
                <ul>Aino, Nieminen, 2006-01-30, 1</ul>
                <ul>Ville, Mäkinen, 2005-09-12, 2</ul>
                <ul>Saara, Lehtonen, 2004-05-18, 3</ul>
                <ul>Oskari, Koskinen, 2006-08-25, 1</ul>
                <ul>Liisa, Järvinen, 2005-12-03, 2</ul>
                <ul>Lilja, Manninen, 2006-04-01, 2</ul>
                <ul>Lilja, Nieminen, 2006-04-12, 3</ul>
                <ul>Antti, Vuori, 2003-10-08, 2</ul>
                <ul>Sade, Lahtinen, 2005-11-12, 2</ul>
                <ul>Ville, Virtanen, 2004-06-03, 2</ul>
                <ul>Sini, Järvinen, 2004-11-08, 1</ul>
                <ul>Maria, Lehtonen, 2004-12-30, 2</ul>
                <ul>Thomas, Karhu, 2004-10-25, 1</ul>
                <ul>Riku, Mäkinen, 2003-12-11, 3</ul>
                <ul>Aamu, Ojala, 2003-12-08, 1</ul>
                <ul>Alex, Hautamäki, 2003-08-06, 2</ul>
                <ul>Riku, Aalto, 2005-10-17, 3</ul>
                <ul>Alina, Korhonen, 2005-12-26, 2</ul>
                <ul>Sini, Kosonen, 2005-07-04, 3</ul>
                <ul>Janina, Vuori, 2004-10-29, 1</ul>
                <ul>Aamu, Lahtinen, 2006-08-19, 1</ul>
                <ul>Mari, Ojala, 2003-05-09, 3</ul>
                <ul>Sini, Karhu, 2006-01-01, 1</ul>
                <ul>Henni, Mäkinen, 2004-06-10, 2</ul>
                <ul>Otso, Lahtinen, 2004-11-02, 1</ul>
                <ul>Kalle, Pitkänen, 2005-09-02, 3</ul>
                <ul>Maria, Hämäläinen, 2006-12-05, 1</ul>
                <ul>Janina, Kallioinen, 2004-05-07, 1</ul>
                <ul>Sanna, Hautamäki, 2005-02-04, 2</ul>
                <ul>Aamu, Jokinen, 2004-10-03, 1</ul>
                <ul>Aaro, Kallioinen, 2005-09-19, 3</ul>
                <ul>Sini, Hautamäki, 2006-07-06, 3</ul>
                <ul>Heidi, Karhu, 2003-10-04, 3</ul>
                <ul>Elmeri, Mäkinen, 2006-06-29, 1</ul>
                <ul>Niko, Tuominen, 2004-08-22, 3</ul>
                <ul>Mari, Saarinen, 2005-06-06, 2</ul>
                <ul>Petteri, Saarinen, 2006-02-11, 2</ul>
                <ul>Aamu, Rantanen, 2003-04-06, 1</ul>
                <ul>Minna, Mäkinen, 2005-08-27, 2</ul>
                <ul>Samuli, Karhu, 2004-09-06, 2</ul>
                <ul>Otso, Karhu, 2005-12-30, 1</ul>
                <ul>Sade, Vuori, 2003-09-22, 3</ul>
                <ul>Ville, Savolainen, 2004-02-20, 1</ul>
                <ul>Elmeri, Aalto, 2005-08-23, 1</ul>
                <ul>Heidi, Seppänen, 2006-06-20, 2</ul>
                <ul>Alina, Lahtinen, 2004-02-02, 3</ul>
                <ul>Heidi, Kivinen, 2006-09-27, 1</ul>
                <ul>Sade, Koivisto, 2006-11-15, 3</ul>
                <ul>Antti, Aalto, 2003-05-15, 3</ul>
                <ul>Tommi, Peltola, 2004-07-20, 2</ul>
                <ul>Elmeri, Hautamäki, 2003-06-02, 1</ul>
                <ul>Elmeri, Nurmi, 2006-11-24, 2</ul>
                <ul>Oskari, Jokinen, 2004-08-03, 3</ul>
                <ul>Heidi, Vainio, 2005-02-22, 1</ul>
                <ul>Pekka, Mäkelä, 2006-04-09, 2</ul>
            </form>
        </section>
    </main>
    <script>
        const f = document.getElementById('opiskelija-form'), tb = document.querySelector('#opiskelijat-table tbody');
        function loadS() { JSON.parse(localStorage.getItem('students') || '[]').forEach(s => { const tr = document.createElement('tr'); tr.innerHTML = `<td>${s.name}</td><td>${s.email || ''}</td><td></td>`; tb.append(tr); }); }
        f.addEventListener('submit', e => { e.preventDefault(); const s = { name: document.getElementById('opiskelija-nimi').value, email: document.getElementById('opiskelija-email').value }; const arr = JSON.parse(localStorage.getItem('students') || '[]'); arr.push(s); localStorage.setItem('students', JSON.stringify(arr)); tb.innerHTML = ''; loadS(); f.reset(); });
        loadS();
    </script>
</body>

</html>
