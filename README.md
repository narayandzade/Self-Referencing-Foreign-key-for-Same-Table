# Self-Referencing-Foreign-key-for-Same-Table
The given PHP code connects to a database using PDO (PHP Data Objects), fetches data from the "members" table, and then generates a hierarchical tree structure from the fetched data. Finally, it prints the hierarchical tree as an HTML list.
Let's break down the code step by step:

A new Database object is created, and the connection is established with the database using the Connection() method of the Database class.

A SQL query is defined to select data from the "members" table, fetching the 'id', 'name', and 'parentid' columns.

The query is executed using the query() method of the connected database, and the result is stored in the $result variable.

The fetched data is then converted to an associative array using the fetchAll(PDO::FETCH_ASSOC) method, and it is stored in the $members array.

A recursive function MakeTree is defined to convert the flat array of members into a hierarchical tree structure.

The function MakeTree takes two parameters: $members, which is the array of members, and $parentID, which is optional and defaults to null.

Inside the MakeTree function, an empty array $tree is created, which will store the hierarchical tree structure.

The function iterates over each member in the $members array using a foreach loop.

For each member, the function checks if its 'parentid' matches the given $parentID. If it matches, it means the current member is a child of the parent represented by the $parentID.

If the condition in step 9 is true, the function calls itself recursively with the $members array and the 'id' of the current member as the new $parentID. This recursive call is made to find all the children of the current member.

The result of the recursive call is stored in the $children variable.

If $children is not empty, it means that the current member has children. In that case, the $children array is assigned to a new key 'children' in the current member array. This way, the current member now contains information about its children.

The current member is then added to the $tree array, which represents the hierarchical tree structure.

The loop continues, and the next member in the $members array is processed in the same manner.

After all members have been processed through the loop, the function will have constructed the complete hierarchical tree structure.

The final $tree array, representing the hierarchical tree structure, is returned.

Outside the function, the code calls the MakeTree function passing the $members array as an argument. This call initializes the process of constructing the hierarchical tree.

The resulting hierarchical tree is stored in the variable $membersHierarchy.

The HTMLTree function is defined to generate the HTML representation of the hierarchical tree.

The function HTMLTree takes the hierarchical tree structure as input and starts by printing an unordered list (<ul>).

It iterates over each node in the tree and prints a list item (<li>) for each node with its 'name'.

If the current node has children (i.e., if the 'children' key is set), the function recursively calls itself to generate the HTML for the children of the current node.

After processing all the children (if any), the closing </li> tag is printed.

The function continues this process for all nodes in the tree, generating the entire HTML representation.

Finally, outside the function, the code calls the HTMLTree function passing the $membersHierarchy (hierarchical tree) as an argument. This call generates and prints the HTML representation of the hierarchical tree.

Note: The HTMLTree function is called twice in this code. The first call is to print the HTML representation when the PHP script is loaded, and the second call is inside the HTMLTree function itself when it needs to print the HTML representation of the children nodes recursively.
