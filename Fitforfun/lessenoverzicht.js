document.getElementById('filter').addEventListener('input', function () {
  const filterValue = this.value.toLowerCase().trim();
  const lessons = document.querySelectorAll('.lesson-card');
  let found = false;

  lessons.forEach(lesson => {
    const lessonName = lesson.dataset.lesson.toLowerCase();
    if (lessonName.includes(filterValue)) {
      lesson.style.display = 'block';
      found = true;
    } else {
      lesson.style.display = 'none';
    }
  });

  document.getElementById('noResults').style.display = found ? 'none' : 'block';
});

document.getElementById('priceFilter').addEventListener('change', function () {
  const selectedPrice = parseFloat(this.value);
  const lessons = document.querySelectorAll('.lesson-card');
  let found = false;

  lessons.forEach(lesson => {
    const lessonPrice = parseFloat(lesson.querySelector('.lesson-price').textContent.replace('Maandprijs: €', '').trim());
    if (lessonPrice <= selectedPrice) {
      lesson.style.display = 'block';
      found = true;
    } else {
      lesson.style.display = 'none';
    }
  });

  document.getElementById('noResults').style.display = found ? 'none' : 'block';
});

document.getElementById('dateFilter').addEventListener('change', function () {
  const selectedDate = this.value;
  const lessons = document.querySelectorAll('.lesson-card');
  let found = false;

  lessons.forEach(lesson => {
    const lessonDate = lesson.querySelector('.lesson-date').textContent.replace('Lesdatum: ', '').trim();
    if (lessonDate.includes(selectedDate)) {
      lesson.style.display = 'block';
      found = true;
    } else {
      lesson.style.display = 'none';
    }
  });

  document.getElementById('noResults').style.display = found ? 'none' : 'block';
});
