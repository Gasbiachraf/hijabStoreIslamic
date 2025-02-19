import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();


const sideBar = document.querySelector('#sideBar');
const closeIcone = document.querySelector('#closeMenu');
const menuIcone = document.querySelector('#menuIcon');
closeIcone.addEventListener('click',()=>{
    sideBar.classList.remove('fixed', 'z-[9999]')
    sideBar.classList.add('hidden')
    closeIcone.classList.add('hidden')
})
menuIcone.addEventListener('click',()=>{
    sideBar.classList.remove('hidden')
    sideBar.classList.add('fixed', 'z-[9999]')
    closeIcone.classList.remove('hidden')
})


const options = {
    chart: {
        height: 380,
        width: "100%",
        type: "line",
    },
    stroke: {
        curve: "smooth",
    },
    series: [
        {
            name: "Product",
            data: total30daysSells
        },
    ],
    xaxis: {
        type: "datetime",
    },
};
const optionsPie = {
    chart: {
        height: 380,
        width: "100%",
        type: "donut",
    },
    stroke: {
        curve: "smooth",
    },
    series: totalCategories,
    labels: topCategories,
};

const chart = new ApexCharts(document.querySelector("#chart"), options);
const chartPie = new ApexCharts(
    document.querySelector("#pieChart"),
    optionsPie
);

chart.render();
chartPie.render();
