import org.jibble.pircbot.PircBot;

import java.awt.*;
import java.awt.event.KeyEvent;

/**
 * Created by Joseph Mortensen on 7/6/2015.
 * ¯\_(ツ)_/¯
 */
public class MainClass {
    public static void main(String[] args) {
        TwitchConsumer tc = new TwitchConsumer();
        tc.doStuff();
    }
}

class TwitchConsumer extends PircBot {

    Robot robot = null;

    public TwitchConsumer() {
        super();
        try {
            robot = new Robot();
        } catch (Exception e) {
            e.printStackTrace();
        }

        setName("cs313playspokemon");
        setAutoNickChange(true);
    }

    public void doStuff() {
        try {
            // don't push this to github or something really, really bad could happen
            System.out.println("finished constructor");
            connect("irc.twitch.tv", 6667, Credentials.stream_key);
            System.out.println("connected");
            joinChannel(Credentials.stream_name);
            System.out.println("joined channel");
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    @Override
    protected void onDisconnect() {
        System.out.println("got disconnected :(");
        int i = 0;
        while (true) {
            try {
                connect("irc.twitch.tv", 6667, Credentials.stream_key);
                System.out.println("connected");
                joinChannel(Credentials.stream_name);
                System.out.println("joined channel");

                if (i > 0) {
                    // toggle twitch off
                    robot.keyPress(KeyEvent.VK_SHIFT);
                    robot.delay(30);
                    robot.keyPress(KeyEvent.VK_0);
                    robot.delay(30);
                    robot.keyRelease(KeyEvent.VK_0);
                    robot.delay(30);
                    robot.keyRelease(KeyEvent.VK_SHIFT);


                    robot.delay(3000); // wait for it


                    // now it's back on :)
                    robot.keyPress(KeyEvent.VK_SHIFT);
                    robot.delay(30);
                    robot.keyPress(KeyEvent.VK_0);
                    robot.delay(30);
                    robot.keyRelease(KeyEvent.VK_0);
                    robot.delay(30);
                    robot.keyRelease(KeyEvent.VK_SHIFT);
                    System.out.println("restarted twitch, good to go!");
                }

                break;
            } catch (Exception ex) {

                System.out.println("had an issue, retrying");
                if (i > 30) {
                    ex.printStackTrace();
                    break;
                }

                i++;

                try {
                    Thread.sleep(5000 * i);
                } catch (Exception e) { }

            }
        }
    }

    @Override
    protected void onKick(String channel, String kickerNick, String kickerLogin, String kickerHostname, String recipientNick, String reason) {
        System.out.println("someone got kicked\n" + channel + " " + kickerNick + " " + kickerLogin + " " + kickerHostname + " " + recipientNick);
    }

    @Override
    protected void onMessage(String channel, String sender, String login, String hostname, String message) {
        System.out.println("Received message: " + message);
        if (message.equalsIgnoreCase("a")) {

            robot.keyPress(KeyEvent.VK_A);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_A);
        } else if (message.equalsIgnoreCase("b")) {
            robot.keyPress(KeyEvent.VK_B);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_B);
        } else if (message.equalsIgnoreCase("up")) {
            robot.keyPress(KeyEvent.VK_U);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_U);
        } else if (message.equalsIgnoreCase("down")) {
            robot.keyPress(KeyEvent.VK_D);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_D);
        } else if (message.equalsIgnoreCase("left")) {
            robot.keyPress(KeyEvent.VK_L);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_L);
        } else if (message.equalsIgnoreCase("right")) {
            robot.keyPress(KeyEvent.VK_R);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_R);
        } else if (message.equalsIgnoreCase("start")) {
            robot.keyPress(KeyEvent.VK_S);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_S);
        } else if (message.equalsIgnoreCase("select")) {
            robot.keyPress(KeyEvent.VK_X);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_X);
        } else if (message.equalsIgnoreCase("toggle")) {
            robot.keyPress(KeyEvent.VK_SHIFT);
            robot.keyPress(KeyEvent.VK_0);
            robot.delay(30);
            robot.keyRelease(KeyEvent.VK_0);
            robot.keyRelease(KeyEvent.VK_SHIFT);
        } else if (message.equalsIgnoreCase("ping")) {
            this.sendMessage(Credentials.stream_name, "pong");
        }
    }
}
