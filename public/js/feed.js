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


const btnLikes = document.querySelectorAll('.thumbs-up')
const btnFavorites = document.querySelectorAll('.favorite')

btnLikes.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.classList.toggle('click')
    })
})

btnFavorites.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.classList.toggle('click')
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
        dropaction.classList.add('dropActionsPostCard')
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


//ALTERNATION BETWEEN ALL & COMUNICATE POSTS
const tabsPost = document.querySelectorAll('.tab-publication')
const posts = document.querySelectorAll('.publication-card')

tabsPost.forEach(tab => {
    tab.addEventListener('click', () => {

        const filter = tab.dataset.filter

        tabsPost.forEach(t => t.classList.remove('active'))
        tab.classList.add('active')

        posts.forEach(post => {
            const type = post.dataset.type
            if (filter === 'all' || type === filter) {
                post.classList.remove('hidden')
            } else {
                post.classList.add('hidden')
            }
        });
    })

})