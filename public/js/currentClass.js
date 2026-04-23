const tabsClass = document.querySelectorAll('.tab-class')

if (tabsClass) {
    tabsClass.forEach(tabClass => {
        tabClass.addEventListener('click', () => {
            tabsClass.forEach(t => t.classList.remove('activeClass'))
            tabClass.classList.add('activeClass')
        })
    })
}

const contentClass = document.querySelectorAll('.class-content')

contentClass.forEach(content => {
    tabsClass.forEach(tab => {
        tab.addEventListener('click', () => {
            contentClass.forEach(c => c.classList.remove('active'))
            const a = document.querySelector('.' + tab.dataset.currentClass)
            a.classList.add('active')

        })

    })
})