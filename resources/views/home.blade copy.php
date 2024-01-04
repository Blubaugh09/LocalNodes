@extends('layouts.admin')

@section('content')
<!-- Container for GoJS diagram -->
<div id="userDiagram" style="height: 500px;"></div>

<script>
    var nodes = @json($nodes);
    var links = @json($links);
</script>

@endsection

@section('scripts')
@parent
<script src="https://unpkg.com/gojs/release/go.js"></script>
<script>
    // This is the last contacted dates for each user
    var lastContactedDates = @json($lastContactedDates);

    // This is the GoJS diagram code
document.addEventListener('DOMContentLoaded', function () {
    var $ = go.GraphObject.make;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var myDiagram = $(go.Diagram, "userDiagram", {
        "undoManager.isEnabled": true,
        "draggingTool.dragsTree": true,
        layout: $(go.TreeLayout, { angle: 90, layerSpacing: 35 })
    });

    // Changes color of code based on category
    function getNodeColor(nodeData) {
    if (nodeData.categoryColors && nodeData.categoryColors.length > 0) {
        return nodeData.categoryColors[0]; // Modify this logic as needed
    }
    return "#FFFFFF"; // Default color, replace with your preferred color
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
        $(go.Shape, "RoundedRectangle", 
            new go.Binding("fill", "", function(nodeData) {
                var baseColor = getNodeColor(nodeData);
                // Apply transparency only if lastContacted is defined
                if (nodeData.lastContacted) {
                    var lastContactedDate = new Date(nodeData.lastContacted);
                    var now = new Date();
                    var oneWeekAgo = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 7);
                    if (lastContactedDate > oneWeekAgo) {
                        return hexToRGBA(baseColor, 0.5); // 50% transparent
                    }
                }
                return baseColor; // No transparency
            }),
            { strokeWidth: 0 }
        ),

        $(go.Panel, "Vertical",  // This Panel holds all TextBlocks for the node
            { 
                margin: 8,
                alignment: go.Spot.Top 
            },
            $(go.TextBlock,  // This TextBlock is for the user name
                {
                    margin: 4,
                    stroke: "black",  // Assuming the user name is in black
                    font: "bold 14px sans-serif"
                },
                new go.Binding("text", "name")
            ),
            $(go.TextBlock,  // This TextBlock is for the last contacted info
                {
                    margin: 4,
                    stroke: "white",  // The last contacted info in white for contrast
                    font: "12px sans-serif"
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
            {
                click: function(e, obj) {
                    var node = obj.part;
                    if (node.data.key.toString().includes('_')) {
                        var parts = node.data.key.split('_');
                        var contactType = parts[1];
                        var userEndedId = parts[0];

                        // Handle phone contact type
                        if (contactType === 'phone') {
                            var phoneNumber = node.data.name;
                            window.open(`sms:${phoneNumber}`, '_blank');
                        }

                        // Handle email contact type
                        if (contactType === 'email') {
                            var emailAddress = node.data.name;
                            window.open(`mailto:${emailAddress}`, '_blank');
                        }

                        // Update contacteds table for both phone and email
                        fetch('/admin/contacteds', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                contact_type: contactType,
                                user_ended_id: userEndedId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Response from server:", data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    } else {
                        var it = node.findLinksOutOf();
                        while (it.next()) {
                            var link = it.value;
                            var detailNode = link.toNode;
                            detailNode.visible = !detailNode.visible;
                            link.visible = detailNode.visible;
                        }
                        myDiagram.layout.invalidateLayout();
                    }

                }
            }
        );

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




</script>
@endsection




