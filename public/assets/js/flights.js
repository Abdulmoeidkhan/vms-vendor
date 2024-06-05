function addSegment(e) {
    let lastRowId = e.parentNode.parentNode.parentNode.id;
    let lastRowKey = Number(lastRowId.slice(-1));
    let tr = document.createElement("tr");
    document.getElementById('rows').value = lastRowKey + 1;
    tr.setAttribute('id', `segment-${lastRowKey + 1}`);
    tr.innerHTML = lastRowKey < 7 ?
        '<th scope="row">' + (lastRowKey + 1) + '</th>\n' +
        '<td><input list="airline" name="segment-' + (lastRowKey + 1) + '-airline" type="text" id="segment-' + (lastRowKey + 1) + '-airlineSelect" class="form-control" placeholder="Airline" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-flightNo" type="text" class="form-control" id="segment-' + (lastRowKey + 1) + '-flightNo" placeholder="Flight No." minlength="4" maxlength="4" required /></td>\n' +
        '<td><input list="city" name="segment-' + (lastRowKey + 1) + '-depCity" type="text" id="segment-' + (lastRowKey + 1) + '-departureCitySelect" class="form-control" placeholder="Departure City" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-depDate" type="date" id="segment-' + (lastRowKey + 1) + '-depDate" class="form-control" placeholder="Departure Date" required /></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-depTime" type="number" id="segment-' + (lastRowKey + 1) + '-depTime" class="form-control" placeholder="Departure Time" minlength="4" maxlength="4" required /></td>\n' +
        '<td><input list="city" name="segment-' + (lastRowKey + 1) + '-arrCity" type="text" id="segment-' + (lastRowKey + 1) + '-arrivalCitySelect" class="form-control" placeholder="Arrival City" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-arrDate" type="date" id="segment-' + (lastRowKey + 1) + '-arrDate" class="form-control" placeholder="Arrival Date" required /></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-arrTime" type="number" id="segment-' + (lastRowKey + 1) + '-arrTime" class="form-control" placeholder="Arrival Time" minlength="4" maxlength="4" required /></td>\n' +
        '<td><div class="d-flex align-items-center gap-2" id="div-segment-' + (lastRowKey + 1) + '-btn">\n' +
        '<button type="button" class="btn btn-outline-success" onclick="addSegment(this)" id="segment-' + (lastRowKey + 1) + '-btn">\n' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-insert-bottom" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M12 15l0 4" /><path d="M14 17l-4 0" /></svg>\n' +
        '</button><button type="button" class="btn btn-outline-badar" onclick="removeSegment(this)" id="remove-segment-' + (lastRowKey + 1) + '-btn">' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-remove" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M10 16l4 4" /><path d="M10 20l4 -4" /></svg>\n' +
        '</button></div></td>' :
        '<th scope="row">' + (lastRowKey + 1) + '</th>\n' +
        '<td><input list="airline" name="segment-' + (lastRowKey + 1) + '-airline" type="text" id="segment-' + (lastRowKey + 1) + '-airlineSelect" class="form-control" placeholder="Airline" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-flightNo" type="text" class="form-control" id="segment-' + (lastRowKey + 1) + '-flightNo" placeholder="Flight No." minlength="4" maxlength="4" required /></td>\n' +
        '<td><input list="city" name="segment-' + (lastRowKey + 1) + '-depCity" type="text" id="segment-' + (lastRowKey + 1) + '-departureCitySelect" class="form-control" placeholder="Departure City" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-depDate" type="date" id="segment-' + (lastRowKey + 1) + '-depDate" class="form-control" placeholder="Departure Date" required /></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-depTime" type="number" id="segment-' + (lastRowKey + 1) + '-depTime" class="form-control" placeholder="Departure Time" minlength="4" maxlength="4" required /></td>\n' +
        '<td><input list="city" name="segment-' + (lastRowKey + 1) + '-arrCity" type="text" id="segment-' + (lastRowKey + 1) + '-arrivalCitySelect" class="form-control" placeholder="Arrival City" required></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-arrDate" type="date" id="segment-' + (lastRowKey + 1) + '-arrDate" class="form-control" placeholder="Arrival Date" required /></td>\n' +
        '<td><input name="segment-' + (lastRowKey + 1) + '-arrTime" type="number" id="segment-' + (lastRowKey + 1) + '-arrTime" class="form-control" placeholder="Arrival Time" minlength="4" maxlength="4" required /></td>\n' +
        '<td><div class="d-flex align-items-center gap-2" id="div-segment-' + (lastRowKey + 1) + '-btn">\n' +
        '<button type="button" class="btn btn-outline-badar" onclick="removeSegment(this)" id="remove-segment-' + (lastRowKey + 1) + '-btn">' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-remove" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M10 16l4 4" /><path d="M10 20l4 -4" /></svg>\n' +
        '</button></div></td>';
    let elementToBeRemoved = e.parentNode;
    elementToBeRemoved.remove();
    document.getElementById('tableBody').appendChild(tr);
}
function removeSegment(e) {
    let tableComp = e.parentNode.parentNode.parentNode.parentNode;
    let lastRowId = e.parentNode.parentNode.parentNode.id;
    let lastRowKey = Number(lastRowId.slice(-1));
    let elementToBeRemoved = e.parentNode.parentNode.parentNode;
    elementToBeRemoved.remove();
    document.getElementById('rows').value = lastRowKey - 1;
    tableComp.lastElementChild.lastElementChild.innerHTML = lastRowKey > 2 ?
        '<div class="d-flex align-items-center gap-2" id="div-segment-' + (lastRowKey - 1) + '-btn">\n' +
        '<button type="button" class="btn btn-outline-success" onclick="addSegment(this)" id="segment-' + (lastRowKey - 1) + '-btn">\n' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-insert-bottom" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M12 15l0 4" /><path d="M14 17l-4 0" /></svg>\n' +
        '</button><button type="button" class="btn btn-outline-badar" onclick="removeSegment(this)" id="remove-segment-' + (lastRowKey - 1) + '-btn">' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-remove" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M10 16l4 4" /><path d="M10 20l4 -4" /></svg>\n' +
        '</button></div>' :
        '<div class="d-flex align-items-center gap-2" id="div-segment-' + (lastRowKey - 1) + '-btn">\n' +
        '<button type="button" class="btn btn-outline-success" onclick="addSegment(this)" id="segment-' + (lastRowKey - 1) + '-btn">\n' +
        '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-row-insert-bottom" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 6v4a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1z" /><path d="M12 15l0 4" /><path d="M14 17l-4 0" /></svg>\n' +
        '</button></div>';
}