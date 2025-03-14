<?php
include "conn.php";


function fetchSingleValue($conn, $query, $column)
{
    return mysqli_fetch_assoc(mysqli_query($conn, $query))[$column] ?? 0;
}


$queries = [

    "lowStockCount" => "SELECT COUNT(*) AS count FROM products WHERE stock < maintaining_level", // Iselect daw yung table na products at icount yung mga rows. Tapos, iche-check kung yung stock is mas mababa sa maintaining_level
    "totalCustomers" => "SELECT COUNT(*) AS count FROM customers", // Iselect lang yung table na customers and i count kung ilang rows
    "completedProjects" => "SELECT COUNT(*) AS count FROM project WHERE date_ended IS NOT NULL AND date_ended != ''", // Iselect daw yung table na project at icount kung ilang rows. Tapos, ichecheck kung date_ended is hindi NULL (ibig sabihin may end date na). At ichecheck din kung date_ended is hindi empty string (''), para siguradong may laman talaga yung field.
    "activeProjects" => "SELECT COUNT(*) AS count FROM project WHERE date_ended IS NULL OR date_ended !=''", // iselect daw yung table na project and i count kung ilang table rows, then check yung date_ended kung null ba siya or if yung date_ended is empty string
    "pendingPOs" => "SELECT COUNT(*) AS count FROM purchase_orders WHERE status != 'Completed'", // iselect daw yung table na purchase_orders and i count kung ilang rows, then icheck yung status kung not equal ba siya sa Completed
    "completedPOs" => "SELECT COUNT(*) AS count FROM purchase_orders WHERE status = 'Completed'", // iselect daw yung table na purchase_orders and i check yung mga rows, then icheck yung status kung equal ba siya sa Completed
    "totalRevenue" => "SELECT COALESCE(SUM(po_items.subtotal), 0) AS total FROM purchase_orders po
                        LEFT JOIN purchase_order_items po_items ON po.id = po_items.po_id \
                        WHERE po.status = 'Completed'", // iselect yung po_items.subtotal (purchase_order_items, "subtotoal"),0 <== decimal, and tawagin nalang toh as "total" nalang. from table purchase_orders tawagin nalang daw siyang "po" nalang then i left join yung purchase_order_items as "po_items" ON po.id = po_items.po_id. parang yung approach niya is sa database, since naka fk yung po kay po_items, i left join siya yung po.id (purchase_order, "id") = po_items.po_id (purchase_order_sales, "po_id") wherein yung po.status neto (purchase_orders, "status") is "Completed"
    "pendingExpenses" => "SELECT COALESCE(SUM(po_items.subtotal), 0) as total
                        FROM purchase_orders po
                        LEFT JOIN purchase_order_items po_items ON po.id = po_items.po_id
                        WHERE po.statis != 'Completed;"
];
