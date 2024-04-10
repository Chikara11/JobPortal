var editProfile = document.querySelector('.edit');
var backdrop = document.querySelector('.backdrop');
var editModal = document.querySelector('.edit_modal');
var Post = document.querySelector('.PostBtn');
var postModal = document.querySelector('.post_modal');

// Edit Modal
function open_EModal() {
  backdrop.style.display = 'block';
  editModal.style.display = 'block';
}

function close_EModal() {
  backdrop.style.display = 'none';
  editModal.style.display = 'none';
}

// Post Modal
function open_PModal() {
  backdrop.style.display = 'block';
  postModal.style.display = 'block';
}

function close_PModal() {
  backdrop.style.display = 'none';
  postModal.style.display = 'none';
}

// Event handlers
editProfile.onclick = open_EModal;
Post.onclick = open_PModal;

backdrop.onclick = function (event) {
  if (editModal.style.display === 'block') {
    close_EModal();
  } else if (postModal.style.display === 'block') {
    close_PModal();
  }
};