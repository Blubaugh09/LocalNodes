@extends('layouts.admin')

@section('content')
<!-- Container for GoJS diagram -->
<div id="userDiagram" style="height: 80vh;"></div>




<div id="categoryContainer" style="z-index:10000; position: fixed; bottom: 10px; left: 10px; background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
    @foreach($categories as $category)
    <!-- Changed from <li> to <button> for better styling -->
        <button class="categoryButton" onclick="selectCategory('{{ $category->name }}')" style="background-color: {{ $category->color_code }};">{{ $category->name }}</button>
    @endforeach
    <!-- Save Selection Button -->
<button id="saveSelectionButton" onclick="saveCategorySelection()">Save Selection</button>
<!-- Reset Selection Button -->
<button id="resetSelectionButton" onclick="resetDiagram()">Reset Selection</button>

</div>



<script>
    var nodes = @json($nodes);
    var links = @json($links);
</script>

@endsection

@section('scripts')
@parent
<script src="https://unpkg.com/gojs/release/go.js"></script>
<script>

// Assuming myDiagram is already defined as you mentioned
function zoomIn() {
    var zoomIncrement = 0.3; // Define how much you want to zoom each time
    myDiagram.scale += zoomIncrement;
}

// Adding a simple HTML button for zooming
var zoomButton = document.createElement('button');
zoomButton.innerHTML = 'Zoom In';
zoomButton.addEventListener('click', zoomIn);
document.body.appendChild(zoomButton);


    // This is the last contacted dates for each user
    var lastContactedDates = @json($lastContactedDates);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var myDiagram;

    // This is the GoJS diagram code
document.addEventListener('DOMContentLoaded', function () {
    var $ = go.GraphObject.make;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    

    myDiagram = $(go.Diagram, "userDiagram", {
        //initialAutoScale: go.Diagram.Uniform,  // an initial automatic zoom-to-fit
            contentAlignment: go.Spot.Center,  // align document to the center of the viewport
            
            layout:
              $(go.ForceDirectedLayout,  // automatically spread nodes apart
                { maxIterations: 200, defaultSpringLength: 3, defaultElectricalCharge: 10 }) // specify a Diagram.layout that arranges trees
            // other properties are set by the layout function, defined below
          });



    // Function to handle category selection
    window.selectedCategory = null; // Holds the currently selected category
// Array to hold the keys of selected nodes
window.selectedNodes = [];

window.selectCategory = function(categoryName) {
    // Highlight the selected category button
    document.querySelectorAll('.categoryButton').forEach(button => {
        if (button.textContent === categoryName) {
            button.classList.add('selected');
        } else {
            button.classList.remove('selected');
        }
    });



     window.selectedCategory = categoryName;
    console.log("Selected Category: ", categoryName);
    // Add logic here to highlight/select nodes based on the category
};

function getNodeColor(nodeData) {
    // Function to convert hex color to rgba for transparency
    function convertHexToRGBA(hexColor, opacity) {
        var r = parseInt(hexColor.slice(1, 3), 16),
            g = parseInt(hexColor.slice(3, 5), 16),
            b = parseInt(hexColor.slice(5, 7), 16);

        return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + opacity + ')';
    }

    // Check if the node was contacted within the last 14 days
    if (nodeData.lastContacted) {
        var lastContactDate = new Date(nodeData.lastContacted);
        var currentDate = new Date();
        var timeDiff = currentDate.getTime() - lastContactDate.getTime();
        var daysDiff = timeDiff / (1000 * 3600 * 24);

        if (daysDiff <= 14) {
            // If the node has category data, make its color semi-transparent
            if (nodeData.categoryData && nodeData.categoryData.length > 0) {
                return convertHexToRGBA(nodeData.categoryData[0].color_code, 0.5); // 50% transparency
            }
            return "rgba(144, 238, 144, 0.5)"; // Light green with semi-transparency
        }
    }

    // Use the category color if available
    if (nodeData.categoryData && nodeData.categoryData.length > 0) {
        return nodeData.categoryData[0].color_code;
    }

    return "#FFFFFF"; // Default color when no recent contact and no category
}




// Changes the color of the node based on the last contacted date and adds transparency. 
function hexToRGBA(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    if (alpha > 1) alpha = 1; // Ensure alpha is between 0 and 1
    else if (alpha < 0) alpha = 0;

    return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
}

    // Update your nodes with the last contacted information
    nodes.forEach(function(node) {
        if (node.key in lastContactedDates) {
            node.lastContacted = lastContactedDates[node.key];
            // You can add additional logic here for color coding
        }
    });



    // Define the Node template
    myDiagram.nodeTemplate =
    $(go.Node, "Auto",
        $(go.Shape, "Circle",
            new go.Binding("fill", "", getNodeColor), // Existing color binding
            { stroke: "black" }
        ),
            
        $(go.Panel, 
            { defaultAlignment: go.Spot.Top },
            // Icons Panel, in the first row
            $(go.Panel,
                { row: 0, margin: new go.Margin(0, 0, 0, 0) }, // Remove any margin that may create a gap
                new go.Binding("itemArray", "categoryData"),
                {
                    itemTemplate:
                        $(go.Panel,
                            $(go.Shape,
                                {   // Shape properties
                                    desiredSize: new go.Size(20, 20),
                                    margin: 2, 
                                },
                                // Bindings for geometryString, fill, and stroke
                                //new go.Binding("geometryString", "icon_path"),
                                new go.Binding("fill", "color_code"),
                                new go.Binding("stroke", "color_code")
                            ),
                            
                        
                        )
                }
            ),
            

            // This Panel holds all TextBlocks for the node, in the second row
            $(go.Panel, 
                { row: 1, },
                $(go.TextBlock,  // This TextBlock is for the user name
                    {
                        stroke: "black",  // Assuming the user name is in black
                        font: "bold 14px sans-serif",
                        alignment: go.Spot.TopCenter
                    },
                    new go.Binding("text", "name")
                ),
                $(go.TextBlock,  // This TextBlock is for the last contacted info
                    {
                        stroke: "white",  // The last contacted info in white for contrast
                        font: "12px sans-serif",
                        alignment: go.Spot.TopCenter
                    },
                new go.Binding("text", "lastContacted", function(dateString) {
                    if (!dateString) return "";
                    var date = new Date(dateString);
                    var dateOptions = { year: 'numeric', month: '2-digit', day: '2-digit' };
                    var timeOptions = { hour: '2-digit', minute: '2-digit' };
                    return date.toLocaleDateString(undefined, dateOptions) + ' ' + date.toLocaleTimeString(undefined, timeOptions);
                })
                
            ),
            $("Button",
                    {
                        click: function(e, obj) {
                            var node = obj.part.data;
                            window.location.href = `/admin/users/${node.key}/edit`;
                        },
                        visible: false
                    },
                    new go.Binding("visible", "canEdit"),
                    $(go.TextBlock, "Edit")
                )
        ),

         // Phone Button
         $("Panel",
            { 
                alignment: go.Spot.BottomLeft,
                visible: false  // Initially hidden
            },
            new go.Binding("visible", "showButtons"), // Visibility bound to a property
            $("Button",
    { click: function(e, obj) { callUser(obj.part.data.key, obj.part.data.phone); } },
    $(go.TextBlock, "Call")
)
        ),

        // Email Button
        $("Panel",
            { 
                alignment: go.Spot.Bottom,
                visible: false  // Initially hidden
            },
            new go.Binding("visible", "showButtons"), // Visibility bound to a property
            $("Button",
    { click: function(e, obj) { emailUser(obj.part.data.key, obj.part.data.email); } },
    $(go.TextBlock, "Email")
)
        ),
            // Click event to toggle button visibility
        {
            click: function(e, obj) {
                var node = obj.part;
                node.data.showButtons = !node.data.showButtons; // Toggle visibility
                myDiagram.model.updateTargetBindings(node.data); // Update the diagram
            }
        }
        ),

        { 
                selectionAdorned: true,
                selectionChanged: node => handleNodeSelection(node)
            }
        );

        myDiagram.nodeTemplate.click = function(e, obj) {
            if (!window.selectedCategory) return;

    var clickedNode = obj.part;
    if (clickedNode) {
        var sel = myDiagram.selection.toArray();
        console.log("Selecting collection with nodes: ", sel.map(function(n) { return n.data.key; }));

        if (clickedNode.isSelected) {
            // If already selected, remove from the selection
            myDiagram.remove(clickedNode);
        } else {
            // New node selected, add to the selection array
            sel.push(clickedNode);
        }
        myDiagram.selectCollection(sel); // Select all nodes in the array
    }
};


    // Define the Link template
    myDiagram.linkTemplate = $(go.Link, $(go.Shape));

    // Create the model data that will be represented by Nodes and Links
    myDiagram.model = new go.GraphLinksModel(nodes, links);

    // Initially make detail nodes invisible
    myDiagram.model.nodeDataArray.forEach(function(node) {
        if (node.key.toString().includes('_')) {
            var detailNode = myDiagram.findNodeForKey(node.key);
            if (detailNode) {
                detailNode.visible = false;
                var it = detailNode.findLinksOutOf();
                while (it.next()) {
                    it.value.visible = false;
                }
            }
        }
    });






});

function resetDiagram() {
    // Reload the current page
    window.location.reload();
}


function callUser(userId, phoneNumber) {
    // Logic to handle a phone call, e.g., opening a dialer
    window.open(`tel:${phoneNumber}`);

    // Update contacteds table
    updateContactedTable('phone', userId);
}

function emailUser(userId, emailAddress) {
    // Logic to handle email, e.g., opening mail client
    window.open(`mailto:${emailAddress}`);

    // Update contacteds table
    updateContactedTable('email', userId);
}

function updateContactedTable(contactType, userId) {
    fetch('/admin/contacteds', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Ensure csrfToken is defined in your script
        },
        body: JSON.stringify({
            contact_type: contactType,
            user_ended_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response from server:", data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function handleNodeSelection(node) {
    var nodeKey = node.data.key;
    console.log("Handling selection change for node: ", nodeKey, "Selected:", node.isSelected);
    if (node.isSelected) {
        // Node is selected
        if (!window.selectedNodes.includes(nodeKey)) {
            console.log("Adding node to selection: ", nodeKey);
            window.selectedNodes.push(nodeKey);
        }
    } else {
        // Node is deselected
        var index = window.selectedNodes.indexOf(nodeKey);
        if (index > -1) {
            console.log("Removing node from selection: ", nodeKey);
            window.selectedNodes.splice(index, 1);
        }
    }
    console.log("Current selected nodes: ", window.selectedNodes);
}


var categoriesMap = @json($categories->pluck('id', 'name'));
var saveCategoryUrl = "{{ route('admin.member-categories.store') }}";
   

// Function to send selected nodes and category to the backend
function saveCategorySelection() {
    console.log("Saving these nodes: ", window.selectedNodes);
    if (!window.selectedCategory || window.selectedNodes.length === 0) {
        alert("Please select a category and at least one node.");
        return;
    }

    var categoryId = categoriesMap[window.selectedCategory]; // Ensure you have this mapping available

    fetch('/admin/member-categories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            category_id: categoryId,
            members: window.selectedNodes
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log("Members successfully associated with the category.");
         // Reset interaction
         window.selectedCategory = null;
        // Reset the selected nodes and category after successful association
        window.selectedNodes = [];
        window.selectedCategory = null;
        // Update UI to reflect the change
        window.location.reload();
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
}





</script>

<style>
    .categoryButton {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        margin: 2px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        outline: none;
    }
    .categoryButton.selected {
        background-color: #0056b3; /* A darker shade for selected button */
        border: 1px solid #004085;
    }
</style>
@endsection









