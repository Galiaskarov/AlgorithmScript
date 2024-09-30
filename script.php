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
//--------------34 Course Schedule--------------
class Solution {

    /**
     * @param Integer $numCourses
     * @param Integer[][] $prerequisites
     * @return Boolean
     */
    function canFinish($numCourses, $prerequisites) {
        $nodes = [];

        foreach ($prerequisites as $p) {
            if (isset($nodes[$p[0]])) {
                $node = $nodes[$p[0]];
            } else {
                $node = new stdClass();
                $node->neighbors = [];
                $node->visited = false;
                $node->complete = false;
            }

            $node->neighbors[] = $p[1];
            $nodes[$p[0]] = $node;
        }

        foreach ($nodes as $i => $n) {
            if (self::dfs($nodes, $n)) {
                return false;
            }
        }

        return true;
    }

    static function dfs(&$nodes, &$node)
    {
        if ($node === null) {
            return false;
        }

        if ($node->complete === true) {
            return false;
        }

        if ($node->visited === true) {
            return true;
        }

        $node->visited = true;

        foreach ($node->neighbors as $n) {
            if (self::dfs($nodes, $nodes[$n])) {
                return true;
            }
        }

        $node->complete = true;
        return false;
    }
}
//--------------35 Implement Trie (Prefix Tree)--------------
class MyTrie {
    public $tr = [];
    public $isWord = [];
    public $root;
    public $id;

    public function init() {
        $this->root = 0;
        $this->id = 1;
        array_push($this->tr, array_fill(0, 26, -1));
        array_push($this->isWord, false);
    }

    public function newNode() {
        array_push($this->tr, array_fill(0, 26, -1));
        array_push($this->isWord, false);
        $newnode = $this->id;
        $this->id++;
        return $newnode;
    }

    public function add(&$s) {
        $u = $this->root;
        $n = strlen($s);
        for ($i = 0; $i < $n; $i++) {
            $c = ord($s[$i]) - ord('a');
            if ($this->tr[$u][$c] == -1) {
                $this->tr[$u][$c] = $this->newNode();
            }
            $u = $this->tr[$u][$c];
        }
        $this->isWord[$u] = true;
    }

    public function find(&$s) {
        $u = $this->root;
        $n = strlen($s);
        for ($i = 0; $i < $n && $u != -1; $i++) {
            $c = ord($s[$i]) - ord('a');
            $u = $this->tr[$u][$c];
        }
        return $u;
    }
}

class Trie {
    /**
     */
    public $tr;
    function __construct() {
        $this->tr = new MyTrie();
        $this->tr->init();
    }
    /**
     * @param String $word
     * @return NULL
     */
    function insert($word) {
        $this->tr->add($word);
    }

    /**
     * @param String $word
     * @return Boolean
     */
    function search($word) {
        $node =  $this->tr->find($word);
        return $node != -1 && $this->tr->isWord[$node];
    }

    /**
     * @param String $prefix
     * @return Boolean
     */
    function startsWith($prefix) {
        $node =  $this->tr->find($prefix);
        return $node != -1;
    }
}

/**
 * Your Trie object will be instantiated and called as such:
 * $obj = Trie();
 * $obj->insert($word);
 * $ret_2 = $obj->search($word);
 * $ret_3 = $obj->startsWith($prefix);
 */
//--------------36 Coin Change--------------
class Solution {

    /**
     * @param Integer[] $coins
     * @param Integer $amount
     * @return Integer
     */
    function coinChange($coins, $amount) {

        $dp = array_fill(0, $amount + 1, PHP_INT_MAX);
        $dp[0] = 0;

        for ($i = 1; $i <= $amount; $i++) {
            foreach ($coins as $coin) {
                if ($i >= $coin) {
                    $dp[$i] = min($dp[$i], $dp[$i - $coin] + 1);
                }
            }
        }

        return $dp[$amount] !== PHP_INT_MAX ? $dp[$amount] : -1;
    }
}
//--------------37 Product of Array Except Self--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function productExceptSelf($nums) {
        $current = 1;
        $currentOtherSide = 1;

        foreach($nums as $key=>$value){
            $current *= $value;
            $currentOtherSide *= $nums[count($nums) - 1 - $key];
            $res[] = $current;
            $resOtherSide[] = $currentOtherSide;
        }

        for($i = 0;$i < count($nums);$i++){

            $arrRes[] = (isset($res[$i - 1]) ? $res[$i - 1] : 1) *
                (isset($resOtherSide[count($nums) - $i - 2]) ? $resOtherSide[count($nums) - $i - 2] : 1);
        }

        return $arrRes;
    }
}
//--------------38 Min Stack--------------
class MinStack {
    private $stack = [];
    private $minStack = [];

    public function push($value) {
        array_push($this->stack, $value);

        if (empty($this->minStack) || $value <= $this->minStack[count($this->minStack) - 1]) {
            array_push($this->minStack, $value);
        }
    }

    public function pop() {
        if (count($this->stack) > 0) {
            $top = array_pop($this->stack);
            if ($top == $this->minStack[count($this->minStack) - 1]) {
                array_pop($this->minStack);
            }
        }
    }

    public function top() {
        if (count($this->stack) > 0) {
            return $this->stack[count($this->stack) - 1];
        }
    }

    public function getMin() {
        if (count($this->minStack) > 0) {
            return $this->minStack[count($this->minStack) - 1];
        }
    }
    public function getstack() {
        print_r($this->stack);
        echo "<br>";
    }
}
/**
 * Your MinStack object will be instantiated and called as such:
 * $obj = MinStack();
 * $obj->push($val);
 * $obj->pop();
 * $ret_3 = $obj->top();
 * $ret_4 = $obj->getMin();
 */
//--------------39 Validate Binary Search Tree--------------
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
class Solution {

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    public function isValidBST($root, $min = null, $max = null)
    {
        return $root === null || (
                ($min === null || $root->val > $min) &&
                ($max === null || $root->val < $max) &&
                $this->isValidBST($root->left, $min, $root->val) &&
                $this->isValidBST($root->right, $root->val, $max)
            );
    }
}
//--------------40 Number of Islands--------------
class Solution {

    /**
     * @param String[][] $grid
     * @return Integer
     */
    function numIslands($grid) {
        $islands = 0;
        $directions = [[0,1], [0, -1], [1,0],[-1,0]];
        // visited node = 2
        for($i = 0; $i < sizeof($grid); $i++){
            for($j = 0; $j < sizeof($grid[0]); $j++){
                if($grid[$i][$j] === '1'){
                    $islands++;
                    $this->d($i, $j, $grid, $directions);
                }
            }
        }
        return $islands;
    }

    function d($i, $j, &$grid, $directions){
        if($grid[$i][$j] != '1' || ! isset($grid[$i][$j]))
            return;
        $grid[$i][$j] = '2';
        foreach($directions as $dir){
            $r = $i + $dir[0];
            $c = $j + $dir[1];
            $this->d($r, $c, $grid, $directions);
        }
    }
}
//--------------41 Rotting Oranges--------------
class Solution
{

    /**
     * @param Integer[][] $grid
     * @return Integer
     */
    function orangesRotting($grid, $minutes = 0)
    {
        while (false !== strpos(json_encode($grid), '1') && ++$minutes) {
            $copy = $grid;
            for ($i = 0; $i < count($copy); $i++) {
                for ($j = 0; $j < count($copy[$i]); $j++) {
                    if (2 !== $grid[$i][$j]) continue;
                    if (isset($grid[$i - 1]) && 1 === $grid[$i - 1][$j]) $copy[$i - 1][$j] = 2;
                    if (isset($grid[$i + 1]) && 1 === $grid[$i + 1][$j]) $copy[$i + 1][$j] = 2;
                    if (isset($grid[$i][$j - 1]) && 1 === $grid[$i][$j - 1]) $copy[$i][$j - 1] = 2;
                    if (isset($grid[$i][$j + 1]) && 1 === $grid[$i][$j + 1]) $copy[$i][$j + 1] = 2;
                }
            }
            if ($grid === $copy) break;
            $grid = $copy;
        }
        return false !== strpos(json_encode($grid), '1') ? -1 : $minutes;
    }
}
//--------------42 Search in Rotated Sorted Array--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function search($nums, $target) {
        $left = 0;
        $right = count($nums) - 1;

        while($left <= $right){
            $mid = round(($right+$left)/2);
            if($nums[$mid] == $target){
                return $mid;
            }
            #check if left side is sorted
            if($nums[$left] < $nums[$mid]){
                if( $nums[$left] <= $target && $target < $nums[$mid]){
                    $right = $mid -1;

                }else{
                    $left = $mid +1;
                }

            }else{
                if($nums[$mid] < $target &&  $target <= $nums[$right]){
                    $left = $mid +1;

                }else{
                    $right = $mid -1;
                }

            }
        }
        return -1;
    }
}
//--------------43 Combination Sum--------------
class Solution {

    private $target = null;
    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    function combinationSum($candidates, $target) {
        $this->target = $target;

        $this->recursiveSum($candidates, $result);

        return $result ?? [];
    }

    private function recursiveSum($candidates, &$result = [], $path = '')
    {
        if ($path) {
            $sum = array_sum($values = explode(',', $path));

            switch (true) {
                case $sum === $this->target:
                    $result[] = $values;
                case $sum > $this->target:
                    return;
            }
        }

        for ($i = 0; $i < count($candidates); $i++) {
            $this->recursiveSum(array_slice($candidates, $i), $result, ltrim($path . ',' . $candidates[$i], ','));
        }
    }
}
//--------------44 Permutations--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function permute($nums) {
        $res=[];
        if(sizeof($nums)==1){
            array_push($res,[$nums[0]]);
            return $res;
        }
        else{
            foreach($nums as $num){
                $first=array_shift($nums);
                $perms=$this->permute($nums);
                foreach($perms as $perm){
                    array_push($perm,$first);
                    array_push($res,$perm);
                }
                array_push($nums,$first);
            }
        }
        return $res;
    }
}
//--------------45 Merge Intervals--------------
class Solution {

    /**
     * @param Integer[][] $intervals
     * @return Integer[][]
     */
    function merge($intervals) {
        $count = count($intervals);
        if ($count == 1) {
            return $intervals;
        }
        usort($intervals, function($a, $b) {
            $a = $a[0];
            $b= $b[0];
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        $start = $intervals[0];
        $res = [$start];
        $k = 0;
        for ($i = 1; $i < $count; $i++) {
            $old = $res[$k];
            $oleft = $old[0];
            $oright = $old[1];
            $new = $intervals[$i];
            $left = $new[0];
            $right = $new[1];
            if ($left > $oright) {
                $res[] = $new;
                $k++;
            } else {
                if ($right > $oright) {
                    $res[$k][1] = $right;
                }
            }
        }
        return $res;

    }
}
//--------------46 Lowest Common Ancestor of a Binary Tree--------------
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */

class Solution {
    /**
     * @param TreeNode $root
     * @param TreeNode $p
     * @param TreeNode $q
     * @return TreeNode
     */
    function lowestCommonAncestor($root, $p, $q) {
        $pPath=[];
        $qPath=[];
        $this->findPath($root, $p, $pPath);
        $this ->findPath($root, $q, $qPath);

        // Compare the paths to get the first different value
        $i = 0;
        while($i < sizeof($pPath) && $i < sizeof($qPath)){
            if ($pPath[$i] != $qPath[$i])
                break;
            $i += 1;
        }
        return $pPath[$i-1];
    }

    function findPath($root, $target, &$path){
        if($root == null){
            return false;
        }
        array_push($path, $root);
        if($root == $target){
            return true;
        }
        if($this->findPath($root->left, $target, $path) || $this->findPath($root->right, $target, $path) )
            return true;
        array_pop($path);
        return false;
    }
}
//--------------47 Time Based Key-Value Store--------------
class TimeMap {
    /**
     */
    function __construct() {

    }

    /**
     * @param String $key
     * @param String $value
     * @param Integer $timestamp
     * @return NULL
     */
    function set($key, $value, $timestamp) {
        $this->map[$key][$timestamp] = $value;
    }

    /**
     * @param String $key
     * @param Integer $timestamp
     * @return String
     */
    function get($key, $timestamp) {
        if (!isset($this->map[$key])) {
            return '';
        }
        $vals = &$this->map[$key] ?? [];

        if (isset($vals[$timestamp])){
            return $vals[$timestamp];
        }

        if (array_key_last($vals) < $timestamp){
            return end($vals);
        }
        $keys = array_keys($vals);
        $l = 0;
        $r = count($vals) - 1;
        while ($l <= $r) {
            $mid = intdiv($r + $l, 2);
            $midT = $keys[$mid];
            $midV = $vals[$midT];
            $nextT = $keys[$mid + 1] ?? PHP_INT_MAX;

            if ($timestamp > $midT && $timestamp < $nextT) {
                return $midV;
            }

            if ($midT > $timestamp) {
                $r = $mid - 1;
            } else {
                $currentDiff = $timestamp - $midT;
                if ($currentDiff < $minDifff) {
                    $minDifff = $currentDiff;
                    $clossest = $midV;
                }
                $l = $mid + 1;
            }
        }

        return '';
    }
}

/**
 * Your TimeMap object will be instantiated and called as such:
 * $obj = TimeMap();
 * $obj->set($key, $value, $timestamp);
 * $ret_2 = $obj->get($key, $timestamp);
 */
//--------------48 Accounts Merge--------------
class Solution {

    /**
     * @param String[][] $accounts
     * @return String[][]
     */

    function accountsMerge($accounts) {
        $email_to_name = array();
        $graph = array();
        foreach ($accounts as $account) {
            $name = $account[0];
            for ($i = 1; $i < count($account); $i++) {
                $email = $account[$i];
                $graph[$email][] = $account[1];
                $graph[$account[1]][] = $email;
                $email_to_name[$email] = $name;
            }
        }
        $merged = array();
        $seen = array();
        foreach ($graph as $email => $neighbors) {
            if (!in_array($email, $seen)) {
                array_push($seen, $email);
                $stack = array($email);
                $component = array();
                while ($stack) {
                    $node = array_pop($stack);
                    array_push($component, $node);
                    foreach ($graph[$node] as $neighbor) {
                        if (!in_array($neighbor, $seen)) {
                            array_push($seen, $neighbor);
                            array_push($stack, $neighbor);
                        }
                    }
                }
                sort($component);
                array_push($merged, array_merge(array($email_to_name[$email]),$component));
            }
        }
        return $merged;
    }
}
//--------------49 Sort Colors--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @return NULL
     */
    function sortColors(&$a) {
        $next0 = 0;
        $next2 = count($a) - 1;
        $i = 0;
        while (true) {
            if ($i > $next2) {
                break;
            }
            if ($a[$i] == 2) {
                $this->swap($a, $i, $next2);
                $next2--;
            } elseif ($a[$i] == 0) {
                $this->swap($a, $i, $next0);
                $next0++;
                $i++;
            }
            elseif ($a[$i] == 1) {
                $i++;
            }
        }
    }

    function swap(&$a, $i1, $i2) {
        $value = $a[$i1];
        $a[$i1] = $a[$i2];
        $a[$i2] = $value;
    }
}
//--------------50 Word Break--------------
class Solution {

    /**
     * @param String $s
     * @param String[] $wordDict
     * @return Boolean
     */
    function wordBreak($s, $wordDict) {
        if ($s === '') return true;

        $len = strlen($s);
        $cache = [0 => true] + array_fill(1, $len, false);

        for ($i = 0; $i < $len; $i++) {
            for ($j = $i + 1; $j <= $len; $j++) {
                $prefix = substr($s, $i, $j - $i);
                if (in_array($prefix, $wordDict) && $cache[$i]) {
                    $cache[$j] = true;
                    if ($cache[$len]) return true;
                }
            }
        }
        return false;
    }
}
//--------------51 Partition Equal Subset Sum--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @return Boolean
     */
    function canPartition($nums) {
        $target = array_sum($nums) / 2;
        if (!is_int($target)) {
            return false;
        }
        $length = count($nums);
        $canMake = array_fill(0, $target + 1, false);
        $canMake[0] = true;
        for ($i = 1; $i <= $length; $i++) {
            $value = $nums[$i - 1];
            for ($sum = $target; $sum >= 0; $sum--) {
                if ($sum - $value < 0) {
                    break;
                }
                $canMake[$sum] = $canMake[$sum - $value] || $canMake[$sum];
            }
        }

        return $canMake[$target];
    }
}
//--------------52 String to Integer (atoi)--------------
class Solution
{

    /**
     * @param String $s
     * @return Integer
     */
    function myAtoi($s)
    {
        $s = trim($s);
        $leading = true;
        $result = '';
        $sign = '';

        foreach (str_split($s) as $char) {

            if ($char == '+' || $char == '-') {
                if ($sign == '' && $leading) {
                    $sign = $char;
                    continue;
                } else {
                    break;
                }
            }
            if (is_numeric($char)) {
                $leading = false;
                if (strlen($result) == 0 && $char == "0") {
                    continue;
                }
                $result .= $char;
            }
            if (!is_numeric($char)) {
                break;
            }
        }
        $result = $sign . $result;

        if ($result == '' || $result == '+' || $result == '-') {
            return 0;
        } else {
            return max(-2147483648, min(2147483647, (int)$result));
        }
    }
}
//--------------53 Spiral Matrix--------------
class Solution {

    /**
     * @param Integer[][] $matrix
     * @return Integer[]
     */
    function spiralOrder($matrix) {

        $rows =  count($matrix);
        $cols = count($matrix[0]);

        $top = 0;
        $left = 0;
        $right = $cols -1;
        $bottom = $rows -1;

        $output = [];

        while(count($output) < $rows * $cols) {

            for($col = $left;$col <= $right;$col++) {
                $output[] = $matrix[$top][$col];
            }
            for($row = $top +1;$row <= $bottom;$row++) {
                $output[] = $matrix[$row][$right];
            }
            if($top != $bottom) {
                for($col = $right -1;$col >= $left;$col--) {
                    $output[] = $matrix[$bottom][$col];
                }
            }
            if($left != $right) {
                for($row = $bottom -1;$row > $top;$row--) {
                    $output[] = $matrix[$row][$left];
                }
            }
            $left++;
            $right--;
            $top++;
            $bottom--;
        }
        return($output);
    }
}
//--------------54 Subsets--------------
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function backtrack($nums, $cur, &$ans) {
        array_push($ans, $cur);
        for ($i = 0 ; $i < count($nums); $i++) {
            array_push($cur, $nums[$i]);
            $this->backtrack(array_slice($nums, $i+1), $cur, $ans);
            array_pop($cur);
        }
    }
    function subsets($nums) {
        $ans = [];
        $this->backtrack($nums, [], $ans);
        return $ans;
    }
}
//--------------55 Binary Tree Right Side View--------------
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
class Solution {

    /**
     * @param TreeNode $root
     * @return Integer[]
     */
    function rightSideView($root) {
        if (is_null($root)) {
            return [];
        }

        $this->iterateByLevel([$root]);

        return $this->res;
    }

    private function iterateByLevel(array $nodes) {
        $this->res[] = $nodes[count($nodes) - 1]->val;
        $newNodes = [];
        for ($i = 0; $i < count($nodes); $i++) {
            $node = $nodes[$i];
            if ($node->left) {
                $newNodes[] = $node->left;
            }

            if ($node->right) {
                $newNodes[] = $node->right;
            }
        }

        if (!empty($newNodes)) {
            $this->iterateByLevel($newNodes);
        }
    }
}
//--------------56 Longest Palindromic Substring--------------
class Solution {
    public function longestPalindrome($s) {
        $processedStr = "^#";
        for ($i = 0; $i < strlen($s); $i++) {
            $processedStr .= $s[$i] . "#";
        }
        $processedStr .= "$";
        $modifiedString = $processedStr;
        $strLength = strlen($modifiedString);
        $palindromeLengths = array_fill(0, $strLength, 0);
        $center = 0;
        $rightEdge = 0;

        for ($i = 1; $i < $strLength - 1; $i++) {
            $palindromeLengths[$i] = ($rightEdge > $i) ? min($rightEdge - $i, $palindromeLengths[2 * $center - $i]) : 0;

            while ($modifiedString[$i + 1 + $palindromeLengths[$i]] == $modifiedString[$i - 1 - $palindromeLengths[$i]]) {
                $palindromeLengths[$i]++;
            }

            if ($i + $palindromeLengths[$i] > $rightEdge) {
                $center = $i;
                $rightEdge = $i + $palindromeLengths[$i];
            }
        }

        $maxLength = 0;
        $maxCenter = 0;
        for ($i = 0; $i < $strLength; $i++) {
            if ($palindromeLengths[$i] > $maxLength) {
                $maxLength = $palindromeLengths[$i];
                $maxCenter = $i;
            }
        }

        $start = ($maxCenter - $maxLength) / 2;
        $end = $start + $maxLength;

        return substr($s, $start, $end - $start);
    }
}
//--------------57 Unique Paths--------------
class Solution {

    /**
     * @param Integer $m
     * @param Integer $n
     * @return Integer
     */
    function uniquePaths($m, $n) {
        $data = array_fill(0, $n+1, 1);

        for ($i = $m - 1; $i > 0; $i--) {
            for ($j = $n - 1; $j > 0; $j--) {
                $data[$j] = $data[$j] + $data[$j+1];
            }
        }

        return $data[1];
    }
}
//--------------58 Construct Binary Tree from Preorder and Inorder Traversal--------------
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
class Solution {

    /**
     * @param Integer[] $preorder
     * @param Integer[] $inorder
     * @return TreeNode
     */
    function buildTree($preorder, $inorder) {
        if (empty($preorder)) {
            return null;
        }

        $value = array_shift($preorder);
        $pos = array_search($value, $inorder);

        $root = new TreeNode(
            $value,
            $this->buildTree(
                array_slice($preorder, 0, $pos),
                array_slice($inorder, 0, $pos)
            ),
            $this->buildTree(
                array_slice($preorder, $pos),
                array_slice($inorder, $pos + 1)
            )
        );

        return $root;
    }
}
//--------------59 Container With Most Water--------------
class Solution {

    /**
     * @param Integer[] $height
     * @return Integer
     */
    function maxArea($height) {
        $n = count($height);
        if($n < 2)
        {
            return "Number of containers too low.";
        }
        $max_n = pow(10,5);
        if($n > $max_n)
        {
            return "Number of containers exceeds.";
        }
        $result = 0;
        $max_h = pow(10,4);
        $i = 0;
        $j = $n-1;
        while($i < $j)
        {
            if($height[$i] > $max_h)
            {
                return "Height of left container exceeds.";
            }
            if($height[$j] > $max_h)
            {
                return "Height of right container exceeds.";
            }
            $curr = min($height[$i], $height[$j]) * ($j-$i);
            $result = max($result, $curr);
            if($height[$i] < $height[$j])
            {
                $i++;
            }
            else{
                $j--;
            }
        }
        return $result;
    }
}
//--------------60 Letter Combinations of a Phone Number--------------
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $phoneKeyboard = [
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz',
        ];

        $combinations = [];
        $this->generateCombinations($phoneKeyboard, $digits, 0, '', $combinations);
        return $combinations;
    }

    private function generateCombinations($phoneKeyboard, $digits, $index, $current, &$combinations): void
    {
        if ($index === strlen($digits)) {
            $combinations[] = $current;
            return;
        }

        $letters = $phoneKeyboard[$digits[$index]];
        for ($i = 0; $i < strlen($letters); $i++) {
            $this->generateCombinations(
                $phoneKeyboard,
                $digits,
                $index + 1,
                $current . $letters[$i],
                $combinations
            );
        }
    }
}
//--------------61 Word Search--------------
class Solution {

    /**
     * @param String[][] $board
     * @param String $word
     * @return Boolean
     */

    private $board;
    private $used;
    private $width;
    private $height;
    private $result;
    private $currUsed;

    function searchWord($sp, $wordAr, $pos) {
        $this->used[$sp[0]][$sp[1]] = true;
        $this->currUsed[] = $sp;

        if ((isset($this->board[$sp[0]][$sp[1]+1])) && (!$this->used[$sp[0]][$sp[1]+1])){

            if ($this->board[$sp[0]][$sp[1]+1] === $wordAr[$pos])  {
                if ($pos == count($wordAr)-1) {
                    $this->result = true;
                    return;
                } else {
                    $this->searchWord([$sp[0],$sp[1]+1], $wordAr, $pos+1); // if there are letters in the word left - search further, starting with the next letter
                    if(!$this->result){
                        for ($k = $pos; $k < count($this->currUsed); $k++){
                            $this->used[$this->currUsed[$k][0]][$this->currUsed[$k][1]] = false;
                            array_pop($this->currUsed);
                            end($this->currUsed);
                        }
                    }
                }
            }
        }
        if ((isset($this->board[$sp[0]][$sp[1]-1])) && (!$this->used[$sp[0]][$sp[1]-1])){
            if ($this->board[$sp[0]][$sp[1]-1] === $wordAr[$pos])  {
                if ($pos == count($wordAr)-1) {
                    $this->result = true;
                    return;
                } else {
                    $this->searchWord([$sp[0],$sp[1]-1], $wordAr, $pos+1);
                    if(!$this->result){
                        for ($k = $pos; $k < count($this->currUsed); $k++){
                            $this->used[$this->currUsed[$k][0]][$this->currUsed[$k][1]] = false;
                            array_pop($this->currUsed);
                            end($this->currUsed);
                        }
                    }
                }
            }
        }
        if ((isset($this->board[$sp[0]-1][$sp[1]])) && (!$this->used[$sp[0]-1][$sp[1]])){
            if ($this->board[$sp[0]-1][$sp[1]] === $wordAr[$pos])  {
                if ($pos == count($wordAr)-1) {
                    $this->result = true;
                    return;
                } else {
                    $this->searchWord([$sp[0]-1,$sp[1]], $wordAr, $pos+1);
                    if(!$this->result){
                        for ($k = $pos; $k < count($this->currUsed); $k++){
                            $this->used[$this->currUsed[$k][0]][$this->currUsed[$k][1]] = false;
                            array_pop($this->currUsed);
                            end($this->currUsed);
                        }
                    }
                }
            }
        }
        if ((isset($this->board[$sp[0]+1][$sp[1]])) && (!$this->used[$sp[0]+1][$sp[1]])){

            if ($this->board[$sp[0]+1][$sp[1]] === $wordAr[$pos])  {
                if ($pos == count($wordAr)-1) {

                    $this->result = true;
                    return;
                } else {
                    $this->searchWord([$sp[0]+1,$sp[1]], $wordAr, $pos+1);
                    if(!$this->result){
                        for ($k = $pos; $k < count($this->currUsed); $k++){
                            $this->used[$this->currUsed[$k][0]][$this->currUsed[$k][1]] = false;
                            array_pop($this->currUsed);
                            end($this->currUsed);
                        }
                    }
                }
            }
        }
        return;
    }

    function exist($board, $word) {
        $this->width = count($board[0]);
        $this->height = count($board);
        $this->board = $board;
        $this->result = false;
        $startPos = array();
        $wordAr = str_split($word);
        for ($i = 0; $i < $this->height; $i++){
            for ($j = 0; $j < $this->width; $j++){
                if ($board[$i][$j] == $wordAr[0]) {
                    $startPos[] = [$i,$j];
                }
            }
        }
        if (empty($startPos)) {
            return false;
        }

        if (count($wordAr) == 1) {
            return true;
        }

        foreach ($startPos as $sp){
            $this->used = array_fill(0,$this->height,array_fill(0,$this->width,false));
            $this->currUsed = array();
            $this->searchWord($sp, $wordAr, 1);
            if ($this->result) {
                return true;
            }
        }
        return false;
    }
}
//--------------62 Find All Anagrams in a String--------------
class Solution {

    /**
     * @param String $s
     * @param String $p
     * @return Integer[]
     */
    function findAnagrams($s, $p) {
        $pl = strlen($p);
        $sl = strlen($s);

        $out = [];
        $pC = $this->getCCount($p, $pl);
        $rC = $this->getCCount(str_split(substr($s, $i, $pl)), $pl);

        for ($i = 1; $i <= $sl - $pl + 1; $i++) { //sliding window
            if ($pC === $rC) {
                $out[] = $i - 1;
            }
            $pIndex = ord($s[$i - 1]) - ord('a'); //Remove count of last character
            $rC[$pIndex] -= 1;
            $iIndex = ord($s[$i - 1 + $pl]) - ord('a'); //Add count of next character
            $rC[$iIndex] += 1;
        }
        return $out;
    }

    function getCCount($s, $l) {
        $count = array_fill(0, 26, 0);
        for ($i = 0; $i < $l; $i++) {
            $index = ord($s[$i]) - ord('a');
            $count[$index] += 1;
        }
        return $count;
    }
}
//--------------63 Minimum Height Trees--------------
class Solution {

    /**
     * @param Integer $n
     * @param Integer[][] $edges
     * @return Integer[]
     */
    function findMinHeightTrees($n, $edges) {
        if ($n === 1) return [0];

        $adjacencyList = array_fill(0, $n, []);
        $degree = array_fill(0, $n, 0);

        foreach ($edges as $edge) {
            $u = $edge[0];
            $v = $edge[1];
            $adjacencyList[$u][] = $v;
            $adjacencyList[$v][] = $u;
            $degree[$u]++;
            $degree[$v]++;
        }

        $queue = new SplQueue();

        for ($i = 0; $i < $n; $i++) {
            if ($degree[$i] === 1) {
                $queue->enqueue($i);
            }
        }

        $remainingNodes = $n;
        while ($remainingNodes > 2) {
            $numNodesAtCurrentLevel = $queue->count();
            $remainingNodes -= $numNodesAtCurrentLevel;

            for ($i = 0; $i < $numNodesAtCurrentLevel; $i++) {
                $node = $queue->dequeue();

                foreach ($adjacencyList[$node] as $neighbor) {
                    $degree[$neighbor]--;
                    if ($degree[$neighbor] === 1) {
                        $queue->enqueue($neighbor);
                    }
                }
            }
        }

        $result = [];
        while (!$queue->isEmpty()) {
            $result[] = $queue->dequeue();
        }

        return $result;
    }
}
//--------------64 Task Scheduler--------------
class Solution {

    /**
     * @param String[] $tasks
     * @param Integer $n
     * @return Integer
     */
    function leastInterval($tasks, $n) {

        $record = [];
        foreach ($tasks as $task) {
            $record[$task] = isset($record[$task]) ? $record[$task] + 1 : 1;
        }

        sort($record);

        $len = count($record);// kind of tasks
        $max_n = $record[$len - 1] - 1;
        $space = $max_n * $n;

        for ($i=$len - 2; $i >= 0; $i--) {

            $space = $space - min($max_n, $record[$i]);
        }

        return $space > 0 ? count($tasks) + $space : count($tasks);
    }
}
//--------------65 LRU Cache--------------
class LRUCache {
    /**
     * @param Integer $capacity
     */
    private $sv;//for store value
    private $cap;
    function __construct($capacity) {
        $this->sv=[];
        $this->cap=$capacity;
    }

    /**
     * @param Integer $key
     * @return Integer
     */
    function get($key) {
        if(array_key_exists($key,$this->sv)){
            $ans=$this->sv[$key];
            unset($this->sv[$key]);
            $this->sv[$key]=$ans;
            return $ans;
        }
        return -1;
    }

    /**
     * @param Integer $key
     * @param Integer $value
     * @return NULL
     */
    function put($key, $value) {
        if(array_key_exists($key,$this->sv))
            unset($this->sv[$key]);
        $n=count($this->sv);
        if($n==$this->cap){
            reset($this->sv);
            unset($this->sv[key($this->sv)]);
        }
        $this->sv[$key]=$value;
    }
}

/**
 * Your LRUCache object will be instantiated and called as such:
 * $obj = LRUCache($capacity);
 * $ret_1 = $obj->get($key);
 * $obj->put($key, $value);
 */