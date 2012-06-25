<?php

class Node {
  private $_val;

  /**
   * Parent's node.
   * @access private
   * @type Node
   */
  private $_parent;

  /**
   * Left-child's node.
   * @access private
   * @type Node
   */
  private $_left;

  /**
   * Right-child's node.
   * @access private
   * @type Node
   */
  private $_right;

  public function __construct($el) {
    $this->_val = $el;
  }

  /**
   * Get node's value.
   * @access public
   * @return Node
   */
  public function val() {
    return $this->_val;
  }

  /**
   * Get left-child's node.
   * @access public
   * @return Node
   */
  public function left() {
    return $this->_left;
  }

  /**
   * Set left-child's node.
   * @access public
   * @return null
   */
  public function setLeft(Node &$node) {
    $this->_left = $node;
  }

  /**
   * Get right-child's node.
   * @access public
   * @return Node
   */
  public function right() {
    return $this->_right;
  }

  /**
   * Set right-child's node.
   * @access public
   * @return null
   */
  public function setRight(Node &$node) {
    $this->_right = $node;
  }

  /**
   * Get parent's node.
   * @access public
   * @return Node
   */
  public function parent() {
    return $this->_parent;
  }

  /**
   * Set parent's node.
   * @access public
   * @return null
   */
  public function setParent(Node &$node) {
    $this->_parent = $node;
  }

  /**
   * Print out the value of this node and its
   * left and right nodes recursively
   * @access public
   * @return string
   */
  public function display() {
  	if ($this->_left->val() !== null) {
		$this->_left->display();
 	}
  	echo $this->_val;
  	echo ($this->_parent === null || $this->_parent->val() === null) ? " <-" : "", "\n";
 	if ($this->_right->val() !== null) {
 		$this->_right->display();
 	}
  }

  /**
   * Traverse the tree left-to-right to find the depth of the
   * tree.
   */
  public function depthFromNode($depth = 0) {
  	$maxDepth = $depth+1;
  	if ($this->_left->val() !== null) {
  		$left = $this->_left->depthFromNode($depth+1);
  		if ($left > $maxDepth) {
  			$maxDepth = $left;
  		}
  	}
  	if ($this->_right->val() !== null) {
  		$right = $this->_right->depthFromNode($depth+1);
  		if ($right > $maxDepth) {
  			$maxDepth = $right;
  		}
  	}
  	return $maxDepth;
  }

  /**
   * Magic toString function
   * @access public
   * @return string
   */
  public function __toString() {
    return $this->val() === NULL ? 'NULL' : $this->val() . '';
  }
}

class BinarySearchTree {
  /*
   * Top of tree
   */
  private $_root;
  
  /*
   * In place of NULL pointers
   */
  private $_sentinel;

  /*
   * Creates NULL node as sentinel
   * Sets root as sentinel, with left and right and parent pointers to sentinel too
   * @access public
   * @return null
   */
  public function __construct() {
    $this->_sentinel = new Node(NULL);

    $this->_root = $this->_sentinel;
    $this->_root->setParent($this->_sentinel);
    $this->_root->setLeft($this->_sentinel);
    $this->_root->setRight($this->_sentinel);
  }

  /*
   * Inserts new node left or right depending on value
   * @access public
   * @return null
   */
  public function insert($val) {
    if (!is_object($val) || getclass($val) !== 'Node') {
      $newNode = new Node($val);
    } else {
      $newNode = $val;
    }
    $newNode->setLeft($this->_sentinel);
    $newNode->setRight($this->_sentinel);
    
    // Insert first node as root
    if ($this->_root === $this->_sentinel) {
    	$this->_root = $newNode;
    } else {
    	$root = $this->_root;
    	// While the root node is not empty
    	while($root !== $this->_sentinel) {
    		// Don't insert the same value twice
    		if ($newNode->val() == $root->val()) {
    			return;
    		} else if ($newNode->val() < $root->val()) {
    			// Insert recursively to the left for smaller values
    			if ($root->left() === $this->_sentinel) {
    				$newNode->setParent($root);
    				$root->setLeft($newNode);
    				return;
    			} else {
    				$root = $root->left();
    			}
    		} else {
    			// Insert recursively to the right for greater values
    			if ($root->right() === $this->_sentinel) {
    				$newNode->setParent($root);
    				$root->setRight($newNode);
    				return;
    			} else {
    				$root = $root->right();
	   			}
	   		}
    	}
    }
  }

  /**
   * Search for value in tree and return node
   * @access public
   * @return mixed Node or null
   */
  public function search($needle) {
    $node = $this->_root;

	/*
	 * While the current node is not NULL and the value doesn't match,
	 * search left if the needle is smaller than this nodes value
	 * and right otherwise
	 */
    while ($node !== $this->_sentinel && $node->val() !== $needle) {
      if ($needle < $node->val()) {
        $node = $node->left();
      } else {
        $node = $node->right();
      }
    }
    return $node;
  }

  /**
   * Print tree from root downwards left-to-right
   * @access public
   * @return null
   */
  public function traverse() {
  	if ($this->_root !== $this->_sentinel) {
  		$this->_root->display();
  	}
  }

  /**
   * Traverse all routes to leaves and return greatest
   * journey distance
   */
  public function height() {
  	if ($this->_root !== $this->_sentinel) {
  		return $this->_root->depthFromNode();
  	}
  }

}

$BST = new BinarySearchTree;
$BST->insert(15);
$BST->insert(6);
$BST->insert(18);
$BST->insert(3);
$BST->insert(7);
$BST->insert(17);
$BST->insert(20);
$BST->insert(2);
$BST->insert(4);
$BST->insert(13);
$BST->insert(9);


$BST->traverse();

echo "\nHeight: ", $BST->height();

exit;

function test_searching(&$bst, $num) {
  $node = $bst->search($num);
  if ($node->val() !== NULL) {
    echo "Node with value $num is found\n";
    echo "Parent's node = " . $node->parent() . "\n";
    echo "Left-child's node = " . $node->left() . "\n";
    echo "Right-child's node = " . $node->right() . "\n";
  } else {
    echo "Node with value $num is NOT found\n";
  }
  echo "\n";
}

test_searching($BST, 7);
test_searching($BST, 15);
test_searching($BST, 3);
test_searching($BST, 2);
