// var spans = document.querySelectorAll(".auth-nav-Btn");
// var bgColor = "#2a2b38"

// const child1 = document.querySelector('#loginBox');
// const child2 = document.querySelector('#signupBox');

// child1.classList.toggle('show');

// for (var i = 0; i < spans.length; i++) {
//     spans[i].addEventListener("click", function (event) {
//         // Code to execute when the span is clicked
//         // alert("You clicked span number " + (i+1));

//         event.target.style.backgroundColor = "#1C0D1B";
//         event.target.style.filter = "blur(0px)";
//         // event.target.style.transform = "scale(0.8)";

//         let button = event.target.innerText;


//         if (button == "Sign Up") {
//             var otherBtn = document.querySelector("#auth-nav-loginBtn");
//             var mainBox = document.querySelector("#signupBox");
//             var otherBox = document.querySelector("#loginBox");

//         } else if (button == "Log In") {
//             var otherBtn = document.querySelector("#auth-nav-signupBtn");
//             var mainBox = document.querySelector("#loginBox");
//             var otherBox = document.querySelector("#signupBox");
//             // otherBtn.style.backgroundColor = "#2a2b38";
//         }

//         mainBox.style.display = "block";
//         otherBox.style.display = "none";
//         console.log(otherBtn)
//         otherBtn.style.backgroundColor = bgColor;
//         otherBtn.style.filter = "blur(2px)";

//         mainBox.classList.toggle('show')
//         otherBox.classList.toggle('show')

//         // otherBtn.classList.add("blur"); /* Add the "blur" class to the div */

//     });
// }

// // for (var i = 0; i < spans.length; i++) {
// //   spans[i].addEventListener("click", function (event) {

// //   }
// // }

// function selectUserType(event) {
//     const parentElement = event.target.parentElement;
//     const childNodes = parentElement.children;
//     console.log(childNodes.length);
//     for (let i = 0; i < childNodes.length; i++) {
//         const childNode = childNodes[i];
//         if(childNode === event.target){
//             childNode.classList.add('selectedRadio');
//         }else{
//             childNode.classList.remove('selectedRadio');
//         }
//     }

// }

