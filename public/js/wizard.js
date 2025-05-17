// Sélection des éléments
const fieldsets = Array.from(document.querySelectorAll('#msform fieldset'));
const progressBar = document.getElementById('progress-bar');
const toneSelect = document.getElementById('tone');
const themeToggle = document.getElementById('themeToggle');
let current = 0;
const total = fieldsets.length;

// Met à jour la barre
function updateProgress() {
  const pct = ((current + 1) / total) * 100;
  progressBar.style.width = pct + '%';
  progressBar.textContent = `Étape ${current + 1} sur ${total}`;
}
// Affiche l'étape
function showStep(n) {
  fieldsets.forEach((fs, i) => fs.style.display = (i === n ? 'block' : 'none'));
  updateProgress();
}

// Applique le thème selon ton + mode
function applyTheme() {
  const tone = toneSelect.value.replace('_', '-');
  document.documentElement.className = themeToggle.checked
    ? 'dark theme-' + tone
    : 'light theme-' + tone;
}

// Navigation
document.querySelectorAll('.next').forEach(btn => btn.addEventListener('click', () => {
  if (current < total - 1) { current++; showStep(current); }
}));
document.querySelectorAll('.previous').forEach(btn => btn.addEventListener('click', () => {
  if (current > 0) { current--; showStep(current); }
}));

// Preview live and background audio
toneSelect.addEventListener('change', () => {
  // Preview tone and theme
  document.getElementById('previewTone').textContent = toneSelect.selectedOptions[0].text;
  applyTheme();

  // Play full background audio for the selected tone
  if (window.backgroundAudio) {
    window.backgroundAudio.pause();
    window.backgroundAudio.currentTime = 0;
  }
  const tone = toneSelect.value;
  window.backgroundAudio = new Audio(`/sounds/${tone}.mp3`);
  window.backgroundAudio.play();
});
document.getElementById('message').addEventListener('input', e => {
  document.getElementById('previewMessage').textContent = e.target.value;
});
document.getElementById('gif').addEventListener('input', e => {
  const url = e.target.value;
  document.getElementById('previewGif').innerHTML = url
    ? `<img src="${url}" class="img-fluid mt-2">` : '';
});
document.getElementById('sound').addEventListener('input', e => {
  const audio = document.getElementById('previewSound');
  if (e.target.value) { audio.src = e.target.value; audio.style.display = 'block'; }
  else { audio.src = ''; audio.style.display = 'none'; }
});

themeToggle.addEventListener('change', applyTheme);

// Initialisation
showStep(0);
applyTheme();