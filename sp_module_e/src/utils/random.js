export function getRandomInt(min, max) {
    const minCeiled = Math.ceil(min);
    const maxFloored = Math.floor(max);
    return Math.floor(Math.random() * (maxFloored - minCeiled) + minCeiled); // The maximum is exclusive and the minimum is inclusive
}

export function formatImageCaption(name){
    console.log(name)
    name = name.replaceAll('.jpg','')
    name = name.replaceAll('.png','')
    name = name.replaceAll('-',' ')
    let words = name.split(' ');
    words.forEach((word,index)=>{
        words[index] = word[0].toUpperCase() + word.slice(1)
    })
    return words.join(' ')
}