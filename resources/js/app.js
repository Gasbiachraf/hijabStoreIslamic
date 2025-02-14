import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// ^^ blogs :
// var quill = new Quill('#editor', {
//     theme: 'snow'
// });

// // On form submit, update hidden input with Quill content
// document.querySelector('form').addEventListener('change', function() {
//     console.log(quill.root.innerHTML());
//     document.querySelector('#quill-content').value = quill.root.innerHTML();
// });

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
