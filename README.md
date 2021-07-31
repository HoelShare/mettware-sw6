README
---
# Features
This plugin adds a public Order overview (CMSElement) with all orders of the current day.  
It also adds a "Stop Orders" Button. When this button is pressed, no more orders can be placed on this day.
(Orders can be freed in the administration)
When the orders are stopped an event will be dispatched "StopOrdersMessage" 
(perfect for the [MettwareSlack Plugin](https://github.com/HoelShare/mettware-slack))
