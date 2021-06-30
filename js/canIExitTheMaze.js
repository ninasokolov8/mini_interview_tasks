
//given maze
// s- starting point
// o - open door
// k - key
// x - wall (no pass)
// e - exit


//rules -
// we need to know if there is a way to exit the room. return true if we can and false if we cant
// for exiting- you must get the key first
// you can move only up,down,left and right
// you cant pass the 'x' cell (a wall)

//the room arr
let arr = [
    ["s", "x", "o", "o"],
    ['o', 'o', 'o', 'o'],
    ['o', 'x', 'x', 'o'],
    ['o', 'k', 'x', 'e']
]

var isThereAnExit = false;

// find the starting point (the 's' cell in our case)
function findTheStartingPoint(arr,startingPoint) {
    for (let i in arr) {
        for (let j in arr[i]) {
            if (arr[i][j] === startingPoint) { //return our starting point placement
                return [parseInt(i), parseInt(j)]
            }
        }
    }
}

//check if the given cell is passable
function isItLegitCell(arr, level, key, skipArr) {
    if (arr[level][key]) {
        if (skipArr.length > 0) { //check if there are cells that we cant pass through
            let skipCellArrResult = [];
            for (let j in skipArr) {
                if (arr[level][key] !== skipArr[j]) {
                    skipCellArrResult.push(true) // if we can pass
                } else {
                    skipCellArrResult.push(false)// if we cant pass
                }
            }
            //return if we can pass all given conditions.
            return skipCellArrResult.every(v => v === true);
        }
        return true;
    }
    return false;
}

// run through the maze!
function searchForKey(arr, level, key, isKeyFound) {
    let cell = arr[level][key]
    // what cells we cant pass in our way
    let skipCellsArr = ['x', 'v']


    //update flag if you got the key
    if (cell === "k") {
        isKeyFound = true
    } 
    // return in case you have the key and youre at the exit point
    else if (cell === "e" && isKeyFound === true) {
        isThereAnExit = true;
        return;
    }
  
    //if we have the key and we still didnt reach the exit point,
    //unmark the "passed through" v flag, so we will be able to return our steps
     if (isKeyFound) {
        if (cell !== "e") {
            //update the cells we cant pass now in our way
            skipCellsArr = ['x', 'b']
            arr[level][key] = "b"
        }
    }
    // flag the cell that we passed through
    else if (cell !== "e") {
        arr[level][key] = "v"
    }
  
  //start checking all the cells around
  
    //check bottom
    if (arr.length > level + 1) {
        if (isItLegitCell(arr, level + 1, key, skipCellsArr)) {
            searchForKey(arr, level + 1, key, isKeyFound)
        }
    }
    //check left
    if (key > 0) {
        if (isItLegitCell(arr, level, key - 1, skipCellsArr)) {
            searchForKey(arr, level, key - 1, isKeyFound)
        }
    }
    //check top
    if (level > 0) {
        if (isItLegitCell(arr, level - 1, key, skipCellsArr)) {
            searchForKey(arr, level - 1, key, isKeyFound)
        }
    }
    //check right
    if (isItLegitCell(arr, level, key + 1, skipCellsArr)) {
        searchForKey(arr, level, key + 1, isKeyFound)
    }
  
  // if we came into a "dead end" and there is no way out....return.
    return;
}


// start 
//find our starting point in the room
let startPos = findTheStartingPoint(arr,'s')
//check if you can pass the room.
searchForKey(arr, startPos[0], startPos[1], false)
console.log('Can I Get Out? ', isThereAnExit)
//
