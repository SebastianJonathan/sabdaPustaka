// Get the container and the "V" shaped button
loadCustomStyles();
function loadCustomStyles() {
    addStyleSheet(configPath + "CSS/getalllist.css");
}
function addStyleSheet(href) {
    var link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = href;
    document.head.appendChild(link);
}
const containerExpandable = document.querySelector('.container-expandable');
const expandToggle = document.querySelector('.expand-toggle');
// const events = <?php echo json_encode($events); ?>;
// const narasumbers = <?php echo json_encode($narasumbers); ?>;


expandToggle.addEventListener('click', () => {
    // Toggle the visibility of the container
    if (containerExpandable.style.display === 'none') {
        containerExpandable.style.display = 'block';
    } else {
        containerExpandable.style.display = 'none';
    }
});

function generateEventLinks() {
    const eventListContainer = document.getElementById('eventList');
    events.forEach((event) => {
        const eventUrl = configPath + 'PHP/related_results.php?event=' + encodeURIComponent(event);
        const eventDiv = document.createElement('li');
        eventDiv.className = 'event-li';
        // eventDiv.style.width = "150px";
        eventDiv.innerHTML = `<a href="${eventUrl}">${event}</a>`;
        eventListContainer.appendChild(eventDiv);
    });
}

function generateNarasumberLinks() {
    const narasumberListContainer = document.getElementById('narasumberList');
    narasumbers.forEach((narasumber) => {
        const narasumberUrl = configPath + 'PHP/related_results.php?narasumber=' + encodeURIComponent(narasumber);
        const narasumberDiv = document.createElement('li');
        narasumberDiv.className = 'narsum-li';
        // narasumberDiv.style.width = '150px';
        narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${narasumber}</a>`;
        narasumberListContainer.appendChild(narasumberDiv);
    });
}

generateEventLinks();
generateNarasumberLinks();
