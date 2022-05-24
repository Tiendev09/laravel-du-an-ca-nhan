<?php
namespace App\Components;
class Recusive{
    private $data;
    private $htmlSelect = "";
    private $showCatTable = "";
    public function __construct($data)
    {
        $this->data=$data;
    }
    public function showCat($id = 0,$text = ""){
        foreach($this->data as $v){
            if($v->parent_id == $id){
                $this->htmlSelect .= "<option value='{$v->id}'>{$text} {$v->name}</option>";
                $this ->showCat($v->id,$text .'--');
            }
        }
        return $this->htmlSelect;
    }
    public function showCatTable($parent_id = 0, $level = 0){
        $result = [];
    foreach ($this->data as $key => $item)
    {
        if ($item['parent_id'] == $parent_id)
        {
            $result[] = $item;
            $item['level'] = $level;
            // $this->showCatTable .= '<tr>'.
            // '<td>'.$item['id']
            // .'<td>'.$item['name']
            // .'<td>'.$item['created_at']
            // .'<td>'.$item['name'].'</td>'
            // .'</tr>';
            // Xóa chuyên mục đã lặp
            unset($this->data[$key]);
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            // $this->showCatTb($item['id'], $char.'--');
            $result = array_merge($result,$this->showCatTable($item['id'], $level + 1));
        }
    }
    // return $this->showCatTable;
    return $result;
}
// function showCategories($parent_id = 0, $char = '')
// {
//     foreach ($this->data as $key => $item)
//     {
//         // Nếu là chuyên mục con thì hiển thị
//         if ($item['parent_id'] == $parent_id)
//         {
//             echo '<tr>';
//                 echo '<td>';
//                     echo $char . $item['title'];
//                 echo '</td>';
//             echo '</tr>';

//             // Xóa chuyên mục đã lặp
//             unset($categories[$key]);

//             // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
//             showCategories($categories, $item['id'], $char.'|---');
//         }
//     }
// }
}
