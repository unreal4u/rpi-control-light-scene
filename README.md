Raspberry Pi 3 Light Trio Controller
===========

This pure PHP implementation will read out an MQTT broker topic. Depending on the input, it will send other
messages through the same broker, allowing for multiple lights to be turned on or off.

Used materials
--------

The materials used for this build are the following:

* [Sonoff](https://www.aliexpress.com/item/32827328525.html)
* [Tasmota](https://github.com/arendst/Sonoff-Tasmota)
* Raspberry Pi 3b+ (Although any old rPi should be able to handle this program)

Two decorative lamps with sufficient space to hide the sonoff nicely.

How to run the program
--------

This program consists of 1 script. 

It will subscribe to a topic which will inform the status of the playroom light. It will relay whatever
information comes in to two other topics.

This will turn the sonoffs on or off (the payload will actually be the strings "on" or "off").

The actual cronjob is the following:

```
*/2 * * * * /usr/bin/php /home/pi/gpio/controlLightTrio/bin/console light-trio:mqtt-listener
```

Other information
--------

See the following videos:

[How to install Tasmota](https://www.youtube.com/watch?v=IcOFeIcLFFo)

