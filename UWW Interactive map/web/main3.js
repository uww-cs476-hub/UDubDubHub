const bounds = L.latLngBounds([
    [42.8558176838804, -88.70369763947785],
    [42.82770147958312, -88.7812900543213]]);
const map = L.map('map', {
    zoomControl: false,
    maxBounds: bounds,
    minZoom: 15,
    maxBoundsViscosity: 1.0
}).setView([42.840864649583246, -88.74640996583594], 16);
// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     maxZoom: 18,
//     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// }).addTo(map);
L.tileLayer('http://uww.local/tiles/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

L.control.zoom({position: "topright"}).addTo(map);

const shadow = document.getElementById("shadow");
const mapKeys = document.getElementById("keys");
const groups = [];
fetch(".\\buildings.json", {method: "GET"})
    .then((response) => response.json())
    .then((json) => json.groups.forEach(group => {
        const g = group;
        group.members.forEach(member => {
            const poly = L.polygon(member.polys).addTo(map);
            delete member.polys;
            const m = member;

            //each building should get a label.
            // L.marker(poly.getCenter(), {
            //     icon: L.divIcon({
            //         className: 'text-labels',
            //         html: member.name
            //     }),
            //     zIndexOffset: 1000
            // }).addTo(map);

            //create info element before popup.
            member.infoBox = document.createElement("div");
            member.infoBox.classList.add("infobox");
            const infoTitle = document.createElement("p");
            infoTitle.innerText = member.name;
            member.infoBox.appendChild(infoTitle);
            const infoClose = document.createElement("a");
            infoClose.innerText = "x";
            infoClose.href = "javascript:void(0);";
            infoClose.addEventListener("click", (e) => {
                shadow.style.visibility = "hidden";
                m.infoBox.style.visibility = "hidden";
            });
            member.infoBox.appendChild(infoClose);
            const infoNav = document.createElement("div");
            const infoNavList = document.createElement("ul");
            const infoNavTab = document.createElement("li");
            infoNavTab.classList.add("activeTab");
            infoNavTab.innerText = "Info";
            infoNavList.appendChild(infoNavTab);
            infoNav.appendChild(infoNavList);
            const infoNavContent = document.createElement("div");
            const infoNavLabel = document.createElement("p");
            infoNavLabel.innerText = "Street Address:";
            infoNavContent.appendChild(infoNavLabel);
            const infoNavAddr = document.createElement("p");
            infoNavAddr.innerText = member.addr;
            infoNavContent.appendChild(infoNavAddr);
            infoNav.appendChild(infoNavContent);
            member.infoBox.appendChild(infoNav);
            const infoTabBottom = document.createElement("div");
            infoTabBottom.innerText = "Placeholder text";
            member.infoBox.appendChild(infoTabBottom);
            member.infoBox.style.visibility = "hidden";
            document.body.appendChild(member.infoBox);

            const popup = new L.Popup();
            popup.setContent(
                "<div>"+
                    (member.img? ("<img src='"+member.img+"'/>"): "")+
                    "<div>"+
                        "<p>"+member.name+"</p>"+
                        "<p>"+member.addr+"</p>"+
                    "</div>"+
                "</div>"+
                "<a onclick='showInfo(\""+g.name+"\",\""+member.name+"\")' href='javascript:void(0);'>More >></a>");
            
            poly
                .setStyle(g.style)
                .bindPopup(popup)
                .on("click", (e) => poly.setStyle(g.selectedStyle))
                .getPopup().on("remove", (e) => poly.setStyle(g.style));
            member.poly = poly;

            member.searchResult = document.createElement("li");
            member.searchResult.classList.add("result");
            member.searchResult.innerText = member.name;
            member.searchResult.addEventListener("click", (e) => {
                map.panTo(member.poly.getCenter());
                member.poly.setStyle(g.selectedStyle);
                member.poly.openPopup();
            });
        });

        const colorBlockTd = document.createElement("td");
        colorBlockTd.classList.add("mapColor");
        colorBlockTd.style.backgroundColor = g.style.fillColor;
        const keyRow = document.createElement("tr");
        keyRow.appendChild(colorBlockTd);
        const keyValueTd = document.createElement("td");
        keyValueTd.innerText = g.name;
        keyRow.appendChild(keyValueTd);
        mapKeys.appendChild(keyRow);

        g.categoryHeader = document.createElement("li");
        g.categoryHeader.classList.add("category");
        g.categoryHeader.innerText = g.name;

        groups.push(g);
    }));


untilDone(() => {
    const iframe = (
        document.getElementById("embedded").contentDocument ||
        document.getElementById("embedded").contentWindow.document);
    const i = iframe.querySelectorAll("a[href='documents/campus/uwwmap.pdf']");
    if(i && i.length == 2) {
        i[0].remove();
        return true;
    }
    return false;
}, 200);
function untilDone(fn, delay) {
    const f = fn;
    const d = delay;
    setTimeout(() => {
        if(!f())
            untilDone(f, d);
    }, delay);
}

const pageChangeHandler = () => {
    if(document.getElementById("embedded").contentWindow.location.href == "https://www.uww.edu/campus-info/campus") {
        const iframe = (
            document.getElementById("embedded").contentDocument ||
            document.getElementById("embedded").contentWindow.document);
        const i = iframe.querySelectorAll("a[href='documents/campus/uwwmap.pdf']");
        if(i && i.length == 2)
            i[0].remove();
    }
};

const backButton = document.getElementById("backbutton");
backButton.addEventListener("click", (e) => {
    document.getElementById("embedded")
        .contentWindow.history.back();
});
/*
const debug = document.getElementById("debug");
debug.innerHTML = (
    "Lat: " + map.getCenter().lat + 
    "<br>Lng: " + map.getCenter().lng);
map.on("moveend", (e) => {
    const t = map.getCenter();
    const b = map.getBounds();
    debug.innerHTML = (
        "Lat: " + t.lat + 
        "<br>Lng: " + t.lng +
        "<br>North: " + b.getNorth() + 
        "<br>East: " + b.getEast() + 
        "<br>South: " + b.getSouth() + 
        "<br>West: " + b.getWest());
}); */