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
        try {
            // don't push this to github or something really bad could happen
            tc.connect("irc.twitch.tv", 6667, Credentials.stream_key);
            tc.joinChannel(Credentials.stream_name);
        } catch (Exception ex) {
            ex.printStackTrace();
        }
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



    @Override
    protected void onMessage(String channel, String sender, String login, String hostname, String message) {
        System.out.println("Received message: " + message);
        switch (message) {
            case "a":
                robot.keyPress(KeyEvent.VK_A);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_A);
                break;
            case "b":
                robot.keyPress(KeyEvent.VK_B);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_B);
                break;
            case "up":
                robot.keyPress(KeyEvent.VK_U);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_U);
                break;
            case "down":
                robot.keyPress(KeyEvent.VK_D);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_D);
                break;
            case "left":
                robot.keyPress(KeyEvent.VK_L);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_L);
                break;
            case "right":
                robot.keyPress(KeyEvent.VK_R);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_R);
                break;
            case "start":
                robot.keyPress(KeyEvent.VK_S);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_S);
                break;
            case "select":
                robot.keyPress(KeyEvent.VK_X);
                robot.delay(30);
                robot.keyRelease(KeyEvent.VK_X);
                break;
        }
    }
}
