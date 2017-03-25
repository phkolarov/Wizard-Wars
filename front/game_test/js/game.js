// clasical
class Alien{
    makeSomeShit(){
        console.log("Now i'm not human matha facka...")
    }
}

class Human extends Alien{

    constructor(name,age){
        super();
        this.age = age;
        this.name = name;
    };


    get getName(){
        return this.name;
    }
}
//
let pesho = new Human('pesho',12);
pesho.makeSomeShit();
