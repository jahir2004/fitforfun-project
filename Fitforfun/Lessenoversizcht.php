<!DOCTYPE html>

<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lessenoverzicht</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="lessenoverzicht.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Lessenoverzicht</h2>
    
    <div class="mb-3 d-flex justify-content-between">
      <input type="text" id="filter" class="form-control w-25" placeholder="Zoek een sportles..." onkeyup="filterLessons()">
      <select id="priceFilter" class="form-control w-25" onchange="filterLessons()">
        <option value="">Prijs</option>
        <option value="30">€30</option>
        <option value="35">€35</option>
        <option value="40">€40</option>
        <option value="45">€45</option>
        <option value="50">€50</option>
        <option value="55">€55</option>
        <option value="60">€60</option>
      </select>
      <select id="dateFilter" class="form-control w-25" onchange="filterLessons()">
        <option value="">Lesdatum</option>
        <option value="1 maart 2025">1 maart 2025</option>
        <option value="3 maart 2025">3 maart 2025</option>
        <option value="5 maart 2025">5 maart 2025</option>
        <option value="7 maart 2025">7 maart 2025</option>
        <option value="10 maart 2025">10 maart 2025</option>
        <option value="12 maart 2025">12 maart 2025</option>
        <option value="15 maart 2025">15 maart 2025</option>
        <option value="20 maart 2025">20 maart 2025</option>
        <option value="25 maart 2025">25 maart 2025</option>
        <option value="28 maart 2025">28 maart 2025</option>
        <option value="1 april 2025">1 april 2025</option>
        <option value="5 april 2025">5 april 2025</option>
      </select>
    </div>

    <div id="lessonList" class="row">
      <div class="col-md-4 lesson-card" data-lesson="Krachttraining">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Krachttraining</h5>
            <p class="card-text">Focus op spieropbouw en kracht met intensieve gewichtstraining.</p>
            <p class="lesson-price">Maandprijs: €45</p>
            <p class="lesson-date">Lesdatum: 1 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="HIIT">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">HIIT</h5>
            <p class="card-text">Verbrand vet en verbeter je uithoudingsvermogen met High-Intensity Interval Training.</p>
            <p class="lesson-price">Maandprijs: €40</p>
            <p class="lesson-date">Lesdatum: 3 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Core Training">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Core Training</h5>
            <p class="card-text">Versterk je core met gerichte oefeningen voor een betere stabiliteit en houding.</p>
            <p class="lesson-price">Maandprijs: €35</p>
            <p class="lesson-date">Lesdatum: 5 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="CrossFit">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">CrossFit</h5>
            <p class="card-text">Verhoog je kracht, snelheid en uithoudingsvermogen door gevarieerde, intensieve trainingen.</p>
            <p class="lesson-price">Maandprijs: €50</p>
            <p class="lesson-date">Lesdatum: 7 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Powerlifting">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Powerlifting</h5>
            <p class="card-text">Train voor maximale kracht in de drie klassieke powerlifting-oefeningen.</p>
            <p class="lesson-price">Maandprijs: €55</p>
            <p class="lesson-date">Lesdatum: 10 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Bodybuilding">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bodybuilding</h5>
            <p class="card-text">Werk aan spiergroei en esthetiek met gerichte bodybuilding-oefeningen.</p>
            <p class="lesson-price">Maandprijs: €60</p>
            <p class="lesson-date">Lesdatum: 12 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Pilates">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Pilates</h5>
            <p class="card-text">Verbeter je flexibiliteit, houding en spierkracht met gecontroleerde bewegingen.</p>
            <p class="lesson-price">Maandprijs: €38</p>
            <p class="lesson-date">Lesdatum: 15 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Yoga">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Yoga</h5>
            <p class="card-text">Ontspan en verbeter je flexibiliteit met ademhalingstechnieken en stretch-oefeningen.</p>
            <p class="lesson-price">Maandprijs: €30</p>
            <p class="lesson-date">Lesdatum: 20 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Boksen">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Boksen</h5>
            <p class="card-text">Leer techniek, snelheid en kracht met een intensieve bokstraining.</p>
            <p class="lesson-price">Maandprijs: €48</p>
            <p class="lesson-date">Lesdatum: 25 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Zumba">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Zumba</h5>
            <p class="card-text">Dans en train je hele lichaam op energieke Latijns-Amerikaanse muziek.</p>
            <p class="lesson-price">Maandprijs: €42</p>
            <p class="lesson-date">Lesdatum: 28 maart 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Bootcamp">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bootcamp</h5>
            <p class="card-text">Werk aan kracht en uithoudingsvermogen met een combinatie van cardio en krachttraining.</p>
            <p class="lesson-price">Maandprijs: €50</p>
            <p class="lesson-date">Lesdatum: 1 april 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 lesson-card" data-lesson="Calisthenics">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Calisthenics</h5>
            <p class="card-text">Gebruik je eigen lichaamsgewicht voor kracht, balans en controle.</p>
            <p class="lesson-price">Maandprijs: €37</p>
            <p class="lesson-date">Lesdatum: 5 april 2025</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn-reserveer">Reserveer Nu</a>
          </div>
        </div>
      </div>
    </div>

    <p id="noResults" class="text-danger text-center mt-3" style="display: none;">Geen lessen gevonden.</p>
  </div>

  <script src="lessenoverzicht.js"></script>

  
</body>
</html>
