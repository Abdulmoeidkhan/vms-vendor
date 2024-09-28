$(function () {


    // =====================================
    // ORG STATS 
    // =====================================
    if (document.getElementById('orgchart')) {
        axios.get('/getOrganizationStats')
            .then(function (response) {
                let delegationData = response.data;
                // console.log(dataArray(delegationData, 'rejected'))
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'entity_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#orgchart"), chart);
                chart.render();
            })
    }
    else if (document.getElementById('orgRepchart')) {
        axios.get('/getSpecificOrganizationStats')
            .then(function (response) {
                let delegationData = response.data;
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'entity_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#orgRepchart"), chart);
                chart.render();
            })
    }


    // =====================================
    // HR STATS 
    // =====================================
    if (document.getElementById('hrChart')) {
        axios.get('/getHrGroupsStats')
            .then(function (response) {
                let delegationData = response.data;
                // console.log(delegationData);
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'entity_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#hrChart"), chart);
                chart.render();
            })
    }
    else if (document.getElementById('hrRepchart')) {
        axios.get('/getSpecificHrGroupStats')
            .then(function (response) {
                let delegationData = response.data;
                console.log(delegationData)
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'entity_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#hrRepchart"), chart);
                chart.render();
            })
    }

    // =====================================
    // MEDIA STATS 
    // =====================================
    if (document.getElementById('mediaChart')) {
        axios.get('/getMediaStats')
            .then(function (response) {
                let delegationData = response.data;
                // console.log(delegationData)
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'entity_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#mediaChart"), chart);
                chart.render();
            })
    }
    else if (document.getElementById('mediaRepchart')) {
        axios.get('/getSpecificMediaStats')
            .then(function (response) {
                let delegationData = response.data;
                var chart = {
                    series: [
                        { name: "Sent:", data: dataArray(delegationData, 'sent') },
                        { name: "Approved:", data: dataArray(delegationData, 'approved') },
                        { name: "Pending:", data: dataArray(delegationData, 'pending') },
                        { name: "Rejected:", data: dataArray(delegationData, 'rejected') },
                    ],

                    chart: {
                        type: "bar",
                        height: 345,
                        offsetX: -15,
                        toolbar: { show: true },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: { enabled: false },
                    },


                    colors: ["#5D87FF", "#49BEFF", '#ffae1f', '#e32027'],


                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            borderRadius: [5],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        },
                    },
                    markers: { size: 0 },

                    dataLabels: {
                        enabled: false,
                    },


                    legend: {
                        show: true,
                    },


                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },

                    xaxis: {
                        type: "category",
                        categories: dataArray(delegationData, 'media_name'),
                        labels: {
                            style: { cssClass: "grey--text lighten-2--text fill-color" },
                        },
                    },


                    yaxis: {
                        show: true,
                        min: 0,
                        max: 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color",
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"],
                    },


                    tooltip: { theme: "light" },

                    responsive: [
                        {
                            breakpoint: 600,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 3,
                                    }
                                },
                            }
                        }
                    ]


                };

                var chart = new ApexCharts(document.querySelector("#mediaRepchart"), chart);
                chart.render();
            })
    }



    //   // =====================================
    //   // Delegates
    //   // =====================================
    //   axios.get('/getDelegatesStats')
    //     .then(function (response) {
    //       let data = response.data;
    //       var breakup = {
    //         color: "#adb5bd",
    //         series: data.values,
    //         labels: data.names,
    //         chart: {
    //           width: 270,
    //           type: "donut",
    //           fontFamily: "Plus Jakarta Sans', sans-serif",
    //           foreColor: "#adb0bb",
    //         },
    //         plotOptions: {
    //           pie: {
    //             startAngle: 0,
    //             endAngle: 360,
    //             donut: {
    //               size: '75%',
    //             },
    //           },
    //         },
    //         stroke: {
    //           show: false,
    //         },

    //         dataLabels: {
    //           enabled: true,
    //         },

    //         legend: {
    //           show: false,
    //         },
    //         colors: ["#5D87FF", "#ffae1f", "#E32027"],

    //         responsive: [
    //           {
    //             breakpoint: 991,
    //             options: {
    //               chart: {
    //                 width: 150,
    //               },
    //             },
    //           },
    //         ],
    //         tooltip: {
    //           theme: "dark",
    //           fillSeriesColor: false,
    //         },
    //       };

    //       var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
    //       chart.render();
    //     })
    //     .catch(function (error) {
    //       console.log(error);
    //     })

    //   // =====================================
    //   // Flights
    //   // =====================================
    //   axios.get('/getFlightsSummary')
    //     .then(function (response) {
    //       let data = response.data;
    //       console.log(data)
    //       var intlDelegation = {
    //         color: "#adb5bd",
    //         series: data.values,
    //         labels: data.names,
    //         chart: {
    //           width: 270,
    //           type: "donut",
    //           fontFamily: "Plus Jakarta Sans', sans-serif",
    //           foreColor: "#adb0bb",
    //         },
    //         plotOptions: {
    //           pie: {
    //             startAngle: 0,
    //             endAngle: 360,
    //             donut: {
    //               size: '75%',
    //             },
    //           },
    //         },
    //         stroke: {
    //           show: false,
    //         },

    //         dataLabels: {
    //           enabled: true,
    //         },

    //         legend: {
    //           show: false,
    //         },
    //         colors: ["#5D87FF", "#ffae1f", "#E32027"],

    //         responsive: [
    //           {
    //             breakpoint: 991,
    //             options: {
    //               chart: {
    //                 width: 150,
    //               },
    //             },
    //           },
    //         ],
    //         tooltip: {
    //           theme: "dark",
    //           fillSeriesColor: false,
    //         },
    //       };

    //       var chart = new ApexCharts(document.querySelector("#intlDelegation"), intlDelegation);
    //       chart.render();
    //     })
    //     .catch(function (error) {
    //       console.log(error);
    //     })



    //   // =====================================
    //   // Earning
    //   // =====================================
    //   var earning = {
    //     chart: {
    //       id: "sparkline3",
    //       type: "area",
    //       height: 60,
    //       sparkline: {
    //         enabled: true,
    //       },
    //       group: "sparklines",
    //       fontFamily: "Plus Jakarta Sans', sans-serif",
    //       foreColor: "#adb0bb",
    //     },
    //     series: [
    //       {
    //         name: "Earnings",
    //         color: "#49BEFF",
    //         data: [25, 66, 20, 40, 12, 58, 20],
    //       },
    //     ],
    //     stroke: {
    //       curve: "smooth",
    //       width: 2,
    //     },
    //     fill: {
    //       colors: ["#f3feff"],
    //       type: "solid",
    //       opacity: 0.05,
    //     },

    //     markers: {
    //       size: 0,
    //     },
    //     tooltip: {
    //       theme: "dark",
    //       fixed: {
    //         enabled: true,
    //         position: "right",
    //       },
    //       x: {
    //         show: false,
    //       },
    //     },
    //   };
    //   new ApexCharts(document.querySelector("#earning"), earning).render();

    //   // =====================================
    //   // Officer Chart
    //   // =====================================

    //   axios.get('/getOfficerSummary')
    //     .then(function (response) {
    //       let data = response.data;
    //       console.log(data)
    //       var options = {
    //         series: [{
    //           name: 'Assigned',
    //           data: data.values[0]
    //         }, {
    //           name: 'Available',
    //           data: data.values[1]
    //         }],
    //         chart: {
    //           type: 'bar',
    //           height: 200,
    //           stacked: true,
    //           stackType: '100%'
    //         },
    //         colors: ["#5D87FF", "#ffae1f", "#E32027"],
    //         plotOptions: {
    //           bar: {
    //             horizontal: true,
    //           },
    //         },
    //         stroke: {
    //           width: 1,
    //           colors: ['#fff']
    //         },
    //         title: {
    //           // text: 'Officer Chart'
    //         },
    //         xaxis: {
    //           categories: ['Liason', 'Interpreter', 'Receiving'],
    //         },
    //         tooltip: {
    //           y: {
    //             formatter: function (val) {
    //               return val
    //             }
    //           }
    //         },
    //         fill: {
    //           opacity: 1

    //         },
    //         legend: {
    //           position: 'top',
    //           horizontalAlign: 'left',
    //           offsetX: 40
    //         }
    //       };

    //       var officerchart = new ApexCharts(document.querySelector("#officerchart"), options);
    //       officerchart.render();

    //     })
    //   // =====================================
    //   // Delegate Chart
    //   // =====================================

    //   axios.get('/getDelegateSummary')
    //     .then(function (response) {
    //       let data = response.data;

    //       var options = {
    //         series: data.values,
    //         chart: {
    //           width: 380,
    //           type: 'pie',
    //         },
    //         labels: ['Active', 'InActive'],
    //         colors: ["#5D87FF", "#ffae1f",],
    //         responsive: [{
    //           breakpoint: 480,
    //           options: {
    //             chart: {
    //               width: 200
    //             },
    //             legend: {
    //               position: 'bottom'
    //             }
    //           }
    //         }]
    //       };

    //       var delegatechart = new ApexCharts(document.querySelector("#delegatechart"), options);
    //       delegatechart.render();


    //     })

    //   axios.get('/getDelegateGolfSummary')
    //     .then(function (response) {
    //       let data = response.data;

    //       var options = {
    //         series: data.values,
    //         chart: {
    //           width: 380,
    //           type: 'pie',
    //         },
    //         labels: ['Player', 'Non Player'],
    //         colors: ["#5D87FF", "#ffae1f",],
    //         responsive: [{
    //           breakpoint: 480,
    //           options: {
    //             chart: {
    //               width: 200
    //             },
    //             legend: {
    //               position: 'bottom'
    //             }
    //           }
    //         }]
    //       };

    //       var delegategolfchart = new ApexCharts(document.querySelector("#delegategolfchart"), options);
    //       delegategolfchart.render();


    //     })
    // })




    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;

        showInstallButton();
    });

    function showInstallButton() {
        let installButton = document.getElementById('installButton'); // Replace with your button ID
        if (installButton) {

            installButton.style.display = 'block';
            installButton.addEventListener('click', () => {
                installButton.style.display = 'none';
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    deferredPrompt = null;
                });
            });
        }
    }
});

// // Custom Function for returning array with values of count
let dataArray = (data, param) => {
    let arrayToReturn = [];
    data.map((value) => {
        arrayToReturn.push(value[param])
    })
    return arrayToReturn;
}
