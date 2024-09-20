<?php
//--------------1 Two Sum------------
//class Solution {
    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target) {
        // Обявляем пустой массив hashMap
        $hashMap = [];
        //Проходимся по массиву $nums
        foreach($nums as $i => $value) {
            // Присваеваем $find разность
            $find = $target - $value;
            // проверяем что $hashMap[$find] отличается от null
            if (isset($hashMap[$find])){
                return [$hashMap[$find], $i];
            }
            $hashMap[$value] = $i;
        }
        return [];
    }
//}
//--------------2 Valid Parentheses--------------
class Solution {
    /**
     * @param String $s
     * @return Boolean
     */
    function isValid($s) {
        $ops = [
            '(', '{', '['
        ];

        $cls = [
            ')', '}', ']'
        ];

        $brs = str_split($s);
        $temp = [];

        foreach($brs as $b) {
            if (in_array($b, $ops)) {
                array_push($temp, $b);
            } else {
                $closing_index = array_search($b, $cls);
                if(end($temp) === $ops[$closing_index]) {
                    array_pop($temp);
                } else {
                    return false;
                }
            }
        }

        if(count($temp) === 0) {
            return true;
        }

        return false;
    }
}
//--------------3 Merge Two Sorted Lists--------------
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
//class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        $head = new ListNode();
        $sorted = $head;

        while ($list1 !==null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $sorted->next = $list1;
                $list1 = $list1->next;
            } else {
                $sorted->next = $list2;
                $list2 = $list2->next;
            }

            $sorted = $sorted->next;
        }

        if ($list1 !== null) {
            $sorted->next = $list1;
        } else if($list2 !== null) {
            $sorted->next = $list2;
        }

        return $head->next;
    }
//}
//--------------4 Best Time to Buy and Sell Stock--------------
//class Solution {

    /**
     * @param Integer[] $prices
     * @return Integer
     */
    function maxProfit($prices) {
        $min_price = PHP_INT_MAX;
        $max_profit = 0;

        foreach($prices as $price){
            if($price < $min_price){
                $min_price = $price;
            } elseif ($price - $min_price > $max_profit){
                $max_profit = $price - $min_price;
            }
        }

        return $max_profit;
    }
//}
//--------------5 Valid Palindrome--------------
//class Solution {
    /**
     * @param String $s
     * @return Boolean
     */
    function isPalindrome($s) {
        $s = str_replace(' ', ',', $s);

        $s = preg_replace("/[^a-zA-Z0-9]+/", "", $s);;

        $s = strtolower($s);

        if(strrev($s) === $s){
            return true;
        }else{
            return false;
        }
    }
//}
//--------------6 Invert Binary Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
//class Solution {

    /**
     * @param TreeNode $root
     * @return TreeNode
     */
    function invertTree($root) {
        if (!$root) {
            return null;
        }

        // Swap the left and right children
        $temp = $root->left;
        $root->left = $root->right;
        $root->right = $temp;

        // Invert the left and right subtrees
        $root->left = $this->invertTree($root->left);
        $root->right = $this->invertTree($root->right);

        return $root;
    }
//}
//--------------7 Valid Anagram--------------
//class Solution {
    /**
     * @param String $s
     * @param String $t
     * @return Boolean
     */
    function isAnagram($s, $t) {
        $arrS = str_split($s);
        $arrT = str_split($t);
        sort($arrS);
        sort($arrT);
        return $arrS == $arrT;
    }
//}
//--------------8 Binary Search--------------
//class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function search($nums, $target) {
        $low = 0;
        $high = count($nums)-1;
        if($nums[$low]==$target)return $low;
        if($nums[$high]==$target)return $high;
        while($low+1<$high){
            $mid =(int)(($low+$high)/2);
            if($target>$nums[$mid]){
                $low=$mid;
            }
            else if($target<$nums[$mid]){
                $high=$mid;
            }
            else{
                return $mid;
            }
        }
        return -1;
    }
//}
//--------------9 Flood Fill--------------
//class Solution {

    /**
     * @param Integer[][] $image
     * @param Integer $sr
     * @param Integer $sc
     * @param Integer $color
     * @return Integer[][]
     */
    function floodFill($image, $sr, $sc, $color) {
        //save our image arr, color and first pixel value in object
        $this->image = $image;
        $this->color = $color;
        //we will use this for stopping recursion (base case)
        $this->checkingValue = $this->image[$sr][$sc];

        if ($this->image[$sr][$sc] == $this->color) {
            return $this->image;
        }

        if (isset($this->image[$sr][$sc])) {
            //call recursive function
            $this->helper($sr, $sc);
        }

        return $this->image;
    }

    function helper($row, $column) {
        //base case
        //first of all we check if current pixel is equal starting pixel
        //if it is not - stop recursion
        if ( $this->image[$row][$column] != $this->checkingValue) {
            return;
        }

        //recursive case
        //fill current pixel with new color
        $this->image[$row][$column] = $this->color;

        //use recursion for pixels connected 4-directionally
        if (isset($this->image[$row + 1][$column])) {
            $this->helper($row + 1, $column);
        }

        if (isset($this->image[$row - 1][$column])) {
            $this->helper($row - 1, $column);
        }

        if (isset($this->image[$row][$column + 1])) {
            $this->helper($row, $column + 1);
        }

        if (isset($this->image[$row][$column - 1])) {
            $this->helper($row, $column - 1);
        }
    }
//}
//--------------10 Lowest Common Ancestor of a Binary Search Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */

//class Solution {
    /**
     * @param TreeNode $root
     * @param TreeNode $p
     * @param TreeNode $q
     * @return TreeNode
     */
    function lowestCommonAncestor($root, $p, $q) {
        $current = $root;
        while($current){
            // if($current == $p || $current == $q)
            //     return $current;
            if($p < $current && $q < $current){
                $current = $current->left;}
            elseif($p > $current && $q > $current){
                $current = $current-> right;}
            else
                return $current;
        }
    }
//}
//--------------11 Balanced Binary Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
//class Solution {

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isBalanced($root) {
        try {
            $this->traverse($root); // let's traverse our tree
        } catch (\Exception $exception) {
            // exception is thrown if any subtree is not balanced
            return false;
        }
        return true;
    }
    private function getHeight($node): int
    {
        if (!$node) {
            return 0; // if node is null, return 0
        }
        $l = $this->getHeight($node->left); // get height of left subtree
        $r = $this->getHeight($node->right); // get height of right subtree
        return 1 + max($l, $r); // return height of current node: 1 + max(left subtree height, right subtree height)
    }

    private function traverse($node)
    {
        if ($node->left) {
            $this->traverse($node->left); // traverse left subtree
        }
        if ($node->right) {
            $this->traverse($node->right); // traverse right subtree
        }
        $lHeight = $this->getHeight($node->left); // get height of left subtree
        $rHeight = $this->getHeight($node->right);// get height of right subtree
        if (abs($lHeight - $rHeight) > 1) { // if difference between left and right subtree height is more than 1
            throw new \Exception('Not balanced'); // throw exception
        }
    }
//}
//--------------12 Linked List Cycle--------------
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
//class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        if (!$head || !$head->next) {
            return false;
        }

        $slow = $head;
        $fast = $head;

        $slow = $slow->next;
        $fast = $fast->next->next;
        if ($slow === $fast) {
            return true;
        }

        while ($fast && $fast->next) {
            $slow = $slow->next;
            $fast = $fast->next->next;

            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }
//}
//--------------13 Implement Queue using Stacks--------------
class MyQueue {

    private $stack = [];
    private $size = 0;

    function __construct() {

    }

    /**
     * @param Integer $x
     * @return NULL
     */
    function push($x) {
        $this->stack[] = $x;
        $this->size++;
    }

    /**
     * @return Integer
     */
    function pop() {
        $top = $this->peek();
        array_shift($this->stack);
        $this->size--;
        return $top;
    }

    /**
     * @return Integer
     */
    function peek() {
        if($this->empty()) return 0;
        return $this->stack[0];
    }

    /**
     * @return Boolean
     */
    function empty() {
        return $this->size === 0;
    }
}
/**
 * Your MyQueue object will be instantiated and called as such:
 * $obj = MyQueue();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->peek();
 * $ret_4 = $obj->empty();
 */
//--------------14 First Bad Version--------------
/* The isBadVersion API is defined in the parent class VersionControl.
      public function isBadVersion($version){} */

//class Solution extends VersionControl {
    /**
     * @param Integer $n
     * @return Integer
     */
    function firstBadVersion($n) {
        $left = 1;
        $right = $n;
        $current = false;
        while($left != $right){
            $current = (int)(($left + $right) / 2);
            if ($this->isBadVersion($current)) {
                $right = $current;
            } else {
                $left = $current + 1;
            }
        }
        return $right;
    }
//}
//--------------15 Ransom Note--------------
//class Solution {
    /**
     * @param String $ransomNote
     * @param String $magazine
     * @return Boolean
     */
    function canConstruct($ransomNote, $magazine) {
        $frequencyMap = [];
        for ($i=0;$i<strlen($magazine);$i++) {
            isset($frequencyMap[$magazine[$i]]) ? $frequencyMap[$magazine[$i]]++ : $frequencyMap[$magazine[$i]] = 1;
        }

        for ($i=0;$i<strlen($ransomNote);$i++) {
            $letter = $ransomNote[$i];
            if (!isset($frequencyMap[$letter])) {
                return false;
            }
            $frequencyMap[$letter]--;
            if ($frequencyMap[$letter] < 0) {
                return false;
            }
        }

        return true;
    }
//}
//--------------16 Climbing Stairs--------------
//class Solution {

    /**
     * @param Integer $n
     * @return Integer
     */
    function climbStairs($n) {
        if ($n == 1) return 1;
        if ($n == 2) return 2;
        if (isset($this->hist[$n])) return $this->hist[$n];
        $this->hist[$n] = $this->climbStairs($n-2)+$this->climbStairs($n-1);
        return $this->hist[$n];
    }
//}
//--------------17 Longest Palindrome--------------
//class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function longestPalindrome($s) {
        $count = count_chars($s, 1);
        $even = [];
        $odd = [];

        foreach ($count as $char => $quantity) {
            if ($quantity % 2 === 1) {
                $odd[] = $quantity;
            }
            else {
                $even[] = $quantity;
            }
        }
        sort($odd);
        $maxOdd = array_pop($odd);
        $count = array_merge($even, $odd);
        $result = (array_sum($count) + $maxOdd) - count($odd);
        return $result;
    }
//}
//--------------18 Reverse Linked List--------------
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
//class Solution {

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function reverseList($head) {
        if (!$head) {
            return $head;
        }

        $currentHead = $head;
        if ($head->next) {
            $currentHead = $this->reverseList($head->next);
            $head->next->next = $head;
        }

        $head->next = null;

        return $currentHead;
    }
//}
//--------------19 Majority Element--------------
//class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function majorityElement($nums) {
        $counts = array_count_values($nums);
        foreach($counts as $num =>$count) {
            if ($count == max($counts)) return $num;
        }
    }
//}
//--------------20 Add Binary--------------
//class Solution {
    /**
     * @param String $a
     * @param String $b
     * @return String
     */
    function addBinary($a, $b) {
        $add = 0;
        $returnStr = "";

        $lengthA = strlen($a);
        $lengthB = strlen($b);

        if($lengthA > $lengthB) {
            $b = str_pad($b, $lengthA, "0", STR_PAD_LEFT);
            $index = $lengthA - 1;

        } else {
            $a = str_pad($a, $lengthB, "0", STR_PAD_LEFT);
            $index = $lengthB - 1;

        }

        while ($index >= 0) {
            $sum = (int) $a[$index] + (int) $b[$index] + $add;

            if($sum > 2) {
                $sum = 1;
                $add = 1;
            } elseif($sum == 2) {
                $sum = 0;
                $add = 1;
            } elseif ($add > 0) {
                $add = 0;
            }
            $a[$index] = $sum;
            $index--;
        }

        if($add > 0) {
            $a = $add . $a;
        }

        return $a;
    }
//}
//--------------21 Diameter of Binary Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
//class Solution {

    private $max = 0;

    /**
     * @param TreeNode $root
     * @return Integer
     */

    function diameterOfBinaryTree($root) {
        $this->recursive($root);
        return $this->max;
    }

    function recursive($node) {
        if($node == null) return 0;

        $left = $node->left == null ? 0 : 1 + $this->recursive($node->left);
        $right = $node->right == null ? 0 : 1 + $this->recursive($node->right);
        $this->max = max($left + $right, $this->max);

        return max($left, $right);
    }
//}
//--------------22 Middle of the Linked List--------------
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
//class Solution {

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function middleNode($head) {
        $fast = $head;
        while ($fast && $fast->next){
            $fast = $fast->next->next;
            $head = $head->next;
        }
        return $head;
    }
//}
//--------------23 Maximum Depth of Binary Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
//class Solution {
    /**
     * @param TreeNode $root
     * @return Integer
     */
    function maxDepth($root) {
        $left  = 0;
        $right = 0;

        if(!$root){
            return max($left, $right);
        }

        if($root->left){
            $left = $this->maxDepth($root->left);
        }

        if($root->right){
            $right = $this->maxDepth($root->right);
        }

        return max($left, $right)+1;
    }

    function lengthTree($root, $left, $right){

    }
//}
//--------------24 Contains Duplicate--------------
//class Solution {
    /**
     * @param Integer[] $nums
     * @return Boolean
     */
    function containsDuplicate($nums) {
        $hashmap = array();
        foreach ($nums as $i => $num) {
            if (isset($hashmap[$num])) {
                return true;
            } else {
                $hashmap[$num] = $i;
            }
        }
        return false;
    }
//}
//--------------25 Maximum Subarray--------------
//class Solution {
    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function maxSubArray($nums) {
        $sum = $max = $nums[0];
        foreach ($nums as $key => $value) {
            if ($sum > 0 && $key !== 0) {
                $sum += $value;
            } else {
                $sum = $value;
            }
            if ($sum > $max) {
                $max = $sum;
            }
        }
        return $max;
    }
//}
//--------------26 Insert Interval--------------
//class Solution {
    /**
     * @param Integer[][] $intervals
     * @param Integer[] $newInterval
     * @return Integer[][]
     */
    function insert($intervals, $newInterval) {
        $start = 0;
        $end = 0;
        $n = count($intervals);

        while ($end < $n) {
            if ($newInterval[0] <= $intervals[$end][1]) {
                if ($newInterval[1] < $intervals[$end][0]) {
                    break;
                }
                $newInterval[0] = min($newInterval[0], $intervals[$end][0]);
                $newInterval[1] = max($newInterval[1], $intervals[$end][1]);
            } else {
                $start++;
            }
            $end++;
        }

        return array_merge(array_slice($intervals, 0, $start), array($newInterval), array_slice($intervals, $end));
    }
//}
//--------------27 01 Matrix--------------
//class Solution {

    public $zeros = [];

    /**
     * @param Integer[][] $mat
     * @return Integer[][]
     */
    function updateMatrix($mat) {
        $distances = [];

        # find zeros coordinates
        foreach ($mat as $x => $row) {
            foreach ($row as $y => $cell) {
                if ($cell === 0) {
                    $this->zeros[] = [$x,$y];
                }
            }
        }

        # find distances
        foreach ($mat as $x => $row) {
            foreach ($row as $y => $cell) {
                $distances[$x][$y] = $this->calculateDistance($mat, $x, $y);
            }
        }

        return $distances;

    }

    function calculateDistance($mat, $x, $y) {
        if ($mat[$x][$y] === 0) {
            return 0;
        }

        # choosing zeros to fit test case time limits for php
        $zeros = count($this->zeros) > 50
            ? $this->findCloseZeroes($mat, $x, $y)
            : $this->zeros;

        # find min distance
        $minDistance = PHP_INT_MAX;
        foreach ($zeros as $zero) {
            $distance = abs($zero[0] - $x) + abs($zero[1] - $y); # formula for searching v/h distance in 2d array
            if ($distance < $minDistance) {
                $minDistance = $distance;
            }
        }

        return $minDistance;
    }

    function findCloseZeroes($mat, $x, $y) {
        # scan cells around to find closest zeroes
        $xLen = count($mat);
        $yLen = count($mat[0]);
        $zeros = [];
        $level = 1;
        $break = false; # break after next level after zeros found
        while (!$break) {
            if ($zeros) {
                $break = true;
            }

            $minX = $x-$level;
            $maxX = $x+$level;
            $minY = $y-$level;
            $maxY = $y+$level;

            for ($i = $minX; $i <= $maxX; $i++) {
                for ($j = $minY; $j <= $maxY; $j++) {
                    if (isset($mat[$i][$j]) && $mat[$i][$j] === 0) {
                        $zeros[] = [$i, $j];
                    }
                }
            }

            $level++;
        }

        return $zeros;
    }
//}
//--------------28 K Closest Points to Origin--------------
//class Solution {

    /**
     * @param Integer[][] $points
     * @param Integer $k
     * @return Integer[][]
     */
    function kClosest($points, $k) {
        $heap = new SplMinHeap();
        foreach($points as $point){
            $distance = sqrt($point[0] * $point[0] + $point[1]*$point[1] );
            $heap->insert([$distance, $point]);
        }
        $res = [];
        for($i=0; $i<$k; $i++){
            $top = $heap->extract();
            $res[]= $top[1];
        }
        return $res;
    }
//}
//--------------29 Longest Substring Without Repeating--------------
//class Solution {
    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s) {
        $longest = 0;
        $left = 0;
        $right = 0;
        $hashMap = [];

        while ($right < mb_strlen($s)) {
            if (isset($hashMap[$s[$right]]) && $hashMap[$s[$right]] >= $left) {
                $left = $hashMap[$s[$right]] + 1;
            }

            $hashMap[$s[$right]] = $right;
            $right++;
            $longest = max($longest, $right - $left);
        }

        return $longest;
    }
//}
// --------------30 3Sum--------------
//class Solution {
    static function threeSum($nums) {
        $res = [];
        sort($nums);
        $count = count($nums);
        while ($count > 2) {
            $r = array_pop($nums);
            foreach ($nums as $k => $l) {
                if(isset($nums[$k + 2]) && $nums[$k + 2] === $l) continue;
                if (!isset($search[$l])) $search[-$l - $r] = [$r, $l];
                else {
                    $res[] = [$search[$l][1], $l, $search[$l][0]];
                    unset($search[$l]);
                }
            }
            unset($search);
            $count--;
        }
        return array_unique($res, SORT_REGULAR);
    }
//}
//--------------31 Binary Tree Level Order Traversal--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
//class Solution {

    /**
     * @param TreeNode $root
     * @return Integer[][]
     */
    function levelOrder($root) {
        $res = [];
        if (is_null($root)) return $res;
        $queue = [];
        $queue[] = $root;
        while (! empty($queue)) {
            $curList = [];

            $size = count($queue);
            for ($i = 0; $i < $size; ++$i) {
                $curNode = array_shift($queue);
                $curList[] = $curNode->val;
                if (!is_null($curNode->left)) {
                    $queue[] = $curNode->left;
                }
                if (!is_null($curNode->right)) {
                    $queue[] = $curNode->right;
                }
            }
            $res[] = $curList;
        }
        return $res;
    }
//}
//--------------32 Clone Graph--------------
/**
 * Definition for a Node.
 * class Node {
 *     public $val = null;
 *     public $neighbors = null;
 *     function __construct($val = 0) {
 *         $this->val = $val;
 *         $this->neighbors = array();
 *     }
 * }
 */

//class Solution {
    /**
     * @param Node $node
     * @return Node
     */
    public $oldToNew=[];
    function cloneGraph($node) {
        if($node == null)
            return $node;
        return $this->dfs($node);
    }

    function dfs($node){
        if(isset($this->oldToNew[$node->val]))
            return $this->oldToNew[$node->val];

        $copy = new Node($node->val);
        $this->oldToNew[$node->val] = $copy;
        foreach($node->neighbors as $nei){
            array_push($copy->neighbors, $this->dfs($nei));
        }
        return $copy;
    }
//}

//--------------33 Evaluate Reverse Polish Notation--------------
//class Solution {

    /**
     * @param String[] $tokens
     * @return Integer
     */
    function evalRPN($tokens) {
        $stack = new SplStack();
        foreach($tokens as $t){
            if(!($t == "+" || $t == "-" || $t == "*" || $t == "/")) $stack->push((int)$t);
            else{
                $n = $stack->pop();
                if($t == "+") $n2 = $stack->pop() + $n;
                else if($t == "-") $n2 = $stack->pop() - $n;
                else if($t == "*") $n2 = $stack->pop() * $n;
                else if($t == "/") $n2 = $stack->pop() / $n;
                $stack->push((int)$n2);
            }
        }
        return $stack->top();
    }
//}
