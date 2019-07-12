Raspberry Pi 3 Light Trio Controller
===========

This pure PHP implementation will read out an MQTT broker topic. Depending on the input, it will send other
messages through the same broker, allowing for multiple lights to be turned on or off.

Used materials
--------

The materials used for this build are the following:

TODO
* [Sonoff](https://www.aliexpress.com/item/32827328525.html)
* [Tasmota](https://github.com/arendst/Sonoff-Tasmota)
* Raspberry Pi 3b+ (Although any old rPi should be able to handle this program)

Schematics
--------

No electronic was actually involved in this project.

How to run the program
--------

This program consists of 1 script. 

It will subscribe to a topic which will inform the status of the playroom light. It will relay whatever
information comes in to two other topics.

This will turn on the sonoffs.
