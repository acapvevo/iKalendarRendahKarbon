
function setObserverChart(navElementID, chart) {
    console.log(10);
    let tab = document.getElementById(navElementID);
    let observer = new MutationObserver(function () {
        if (tab.style.display != 'none') {
            chart.resize();
        }
    });
    observer.observe(tab, {
        attributes: true
    });
}
