<?php

namespace StaffChat;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $message = $event->getMessage();

        if (str_starts_with($message, '&')) {
            if ($player->hasPermission("staffchat.use")) {
                $event->cancel();

                $message = substr($message, 1);

                $formattedMessage = TextFormat::AQUA . "[Staff] " . $player->getName() . ": " . TextFormat::WHITE . $message;

                foreach ($this->getServer()->getOnlinePlayers() as $onlinePlayer) {
                    if ($onlinePlayer->hasPermission("staffchat.use")) {
                        $onlinePlayer->sendMessage($formattedMessage);
                    }
                }

            }
        }
    }
}
