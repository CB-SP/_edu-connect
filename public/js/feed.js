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
        commentBox.classList.toggle('showCommentSection')
    })

})

//DROP ACTIONS FROM POST CARDS
const iconEllipse = document.querySelectorAll('.options-publication-card svg')
const dropactions = document.querySelectorAll('.drop-post-card-actions')

iconEllipse.forEach(icon => {
    icon.addEventListener('click', (e) => {
        e.stopPropagation()
        const dropaction = icon.nextElementSibling
        dropactions.forEach(d => {
            if (d !== dropaction) {
                d.classList.remove('dropActionsPostCard')
            }
        })
        dropaction.classList.toggle('dropActionsPostCard')
    })

})

document.addEventListener('click', (e) => {
    dropactions.forEach(drop => {
        if (!drop.contains(e.target)) {
            drop.classList.remove('dropActionsPostCard')
        } else {
            drop.classList.add('dropActionsPostCard')
        }

    })
})

/*
//ALTERNATION BETWEEN ALL & COMUNICATE POSTS
const postTabs = document.querySelectorAll('.tab-publication')

postTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        postTabs.forEach(t => t.classList.remove('active'))
        tab.classList.add('active')
    })
})*/


//ALTERNATION BETWEEN ALL & COMUNICATE POSTS
const tabsPost = document.querySelectorAll('.tab-publication')
const postContents = document.querySelectorAll('.publication-cards')

tabsPost.forEach(tab => {
    tab.addEventListener('click', () => {

        tabsPost.forEach(t => t.classList.remove('active'))
        tab.classList.add('active')

        postContents.forEach(post => {
            postContents.forEach(p => { p.classList.remove('active-pub') })
            const targetPost = document.getElementById(tab.dataset.type)
            targetPost.classList.add('active-pub')
        })

    })

})