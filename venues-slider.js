document.querySelectorAll('.next').forEach(button => {
    button.addEventListener('click', function(){
        let items = this.parentElement.parentElement.querySelector('.slide').querySelectorAll('.item')
        this.parentElement.parentElement.querySelector('.slide').appendChild(items[0])
    })
})

document.querySelectorAll('.prev').forEach(button => {
    button.addEventListener('click', function(){
        let items = this.parentElement.parentElement.querySelector('.slide').querySelectorAll('.item')
        this.parentElement.parentElement.querySelector('.slide').prepend(items[items.length - 1])
    })
})


