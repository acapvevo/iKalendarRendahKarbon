function initLeaflet(elementID) {
    const map = L.map(elementID).setView([1.460, 103.614], 12);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
    }).addTo(map);

    return map;
}

function setZone(coordinates, map) {
    return L.polygon(coordinates, {
        color: '#' + (Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0')
    }).addTo(map);
}

function setObserver(navElementID, map) {
    let tab = document.getElementById(navElementID);
    let observer = new MutationObserver(function () {
        if (tab.style.display != 'none') {
            map.invalidateSize();
        }
    });
    observer.observe(tab, {
        attributes: true
    });
}

function setPopupData(polygon, zone_number, zone_name, data) {
    const htmlString = `
        <h6 class="text-center"><strong>` + zone_number + `: ` + zone_name + `</strong></h6>
        <p>` + data + `</p>
    `;

    polygon.bindPopup(htmlString);
}
