const tabsClass = document.querySelectorAll('.tab-class')

if (tabsClass) {
    tabsClass.forEach(tabClass => {
        tabClass.addEventListener('click', () => {
            tabsClass.forEach(t => t.classList.remove('activeClass'))
            tabClass.classList.add('activeClass')
        })
    })
}