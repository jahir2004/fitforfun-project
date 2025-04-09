document.addEventListener("DOMContentLoaded", function () {
  const filterButton = document.querySelector("button[type='submit']");
  const lessonContainer = document.getElementById("lessonList");

  function fetchLessons() {
      const filter = document.getElementById("filter").value;
      const priceFilter = document.getElementById("priceFilter").value;
      const dateFilter = document.getElementById("dateFilter").value;

      // AJAX-aanvraag naar PHP-script
      fetch(`fetch_lessons.php?filter=${encodeURIComponent(filter)}&priceFilter=${encodeURIComponent(priceFilter)}&dateFilter=${encodeURIComponent(dateFilter)}`)
          .then(response => response.json())
          .then(lessons => {
              lessonContainer.innerHTML = ""; // Maak de lijst leeg

              if (lessons.length === 0) {
                  lessonContainer.innerHTML = "<p class='text-danger text-center mt-3'>Geen lessen gevonden.</p>";
                  return;
              }

              lessons.forEach(lesson => {
                  const lessonDiv = document.createElement("div");
                  lessonDiv.classList.add("col-md-4", "lesson-card");
                  lessonDiv.innerHTML = `
                      <div class="card">
                          <div class="card-body">
                              <h5 class="card-title">${lesson.naam}</h5>
                              <p class="lesson-price">Prijs: €${lesson.prijs}</p>
                              <p class="lesson-date">Datum: ${lesson.datum}</p>
                              <p class="lesson-time">Tijd: ${lesson.tijd}</p>
                              <p class="lesson-min">Min. personen: ${lesson.min_aantal_personen}</p>
                              <p class="lesson-max">Max. personen: ${lesson.max_aantal_personen}</p>
                              <p class="lesson-availability">Beschikbaarheid: ${lesson.beschikbaarheid}</p>
                              <p class="lesson-notes">${lesson.opmerking}</p>
                          </div>
                          <div class="card-footer">
                              <a href="#" class="btn-reserveer">Reserveer Nu</a>
                          </div>
                      </div>
                  `;
                  lessonContainer.appendChild(lessonDiv);
              });
          })
          .catch(error => console.error("Fout bij laden van lessen:", error));
  }

  // Filterknop activeren zonder herladen
  filterButton.addEventListener("click", function (e) {
      e.preventDefault();
      fetchLessons();
  });

  // Laad lessen bij paginalading
  fetchLessons();
});
