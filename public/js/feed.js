//TOGGLE PUBLICATION MODAL 
const btnNewPost = document.querySelector('.btn-new-publish')
const closeIcon = document.querySelector('.close-icon-btn')
const feedModal = document.querySelector('.feed-modal')
const overlayFeed = document.querySelector('.overlay-feed')

btnNewPost.addEventListener('click', () => {
    overlayFeed.classList.add('active')
    feedModal.classList.add('show')
})

closeIcon.addEventListener('click', () => {
    feedModal.classList.remove('show')
    overlayFeed.classList.remove('active')
})

overlayFeed.addEventListener('click', () => {
    feedModal.classList.remove('show')
    overlayFeed.classList.remove('active')
})

//DISPLAY COMMENT AREA
const btnComments = document.querySelectorAll('.comment')

btnComments.forEach(btnComment => {
    btnComment.addEventListener('click', () => {
        const commentBox = btnComment.parentElement.nextElementSibling
        commentBox.classList.toggle('showComment')
    })

})