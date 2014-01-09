PlayStation 4 Discovery and Wake-up Utility
===========================================
Copyright (C) 2014 Darryl Sokoloski <darryl@sokoloski.ca>

Requirements
------------
In order to wake your PS4 remotely, the PS4 must be in Standby mode.  Check the power management settings to enable Standby mode.

If you just wish to see the current status of your PS4, you do not require a "user credential" number.

For wake-up support, you need to obtain a "user credential" which requires a Vita that has already been paired with the PS4.  You then need to capture and examine the initial few UDP packets sent form the Vita when launching the PS4 Link application.  Under Unix-like (Linux, BSD, OSX) operating systems you can use tcpdump.  The traffic must be captured from your home network's gateway in order to see these packets.  Ensure the Vita is connecting to the PS4 through it's wired interface.

An example capture using tcpdump:

    # tcpdump -s0 -X -n -i <interface> udp and port 987

You'll be looking for a packet that looks like HTTP and contains the string 'user-credential:NNNNNNN'.  Remember the "user credential" number.

Usage Overview
--------------

    Probe:
     -P, --probe
       Probe network for devices.

    Wake:
     -W, --wake <user-credential>
       Wake device using specified user credential.

    Options:
     -B, --broadcast
       Send broadcasts.

     -L, --local-port <port address>
       Specifiy a local port address.

     -H, --remote-host <host address>
       Specifiy a remote host address.

     -R, --remote-port <port address>
       Specifiy a remote port address (default: 987).

     -I, --interface <interface>
       Bind to interface.

     -j, --json
       Output JSON.

     -v, --verbose
       Enable verbose messages.


Examples
--------

To search your whole network for a PS4:

    # ./ps4-wake -vP -B

To search via broadcasts using a specific network interface, eth0 for example:

    # ./ps4-wake -vP -B -I eth0

To send a probe directly to the PS4 using it's IPv4 address, 192.168.1.10 for example:

    # ./ps4-wake -vP -H 192.168.1.10

To wake-up your PS4 using 123456 as the "user credential":

    Via broadcast:
    # ./ps4-wake -vW 123456 -B

    Or, direct:
    # ./ps4-wake -vW 123456 -H 192.168.1.10


To Do
-----

- Add JSON output support.
- Add support for multiple PS4 devices.

