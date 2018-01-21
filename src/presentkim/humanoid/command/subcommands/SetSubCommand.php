<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use presentkim\humanoid\{
  command\PoolCommand, command\SimpleSubCommand, HumanoidMain as Plugin, command\SubCommand
};

class SetSubCommand extends SubCommand{

    /** @var SimpleSubCommand[] */
    protected static $subCommands = [];

    /** @return SimpleSubCommand[] */
    public static function getSubCommands(){
        return self::$subCommands;
    }

    /** @param SimpleSubCommand[] $subCommands */
    public static function setSubCommands(array $subCommands){
        self::$subCommands = $subCommands;
    }

    /** @param SimpleSubCommand $subCommand */
    public static function addSubCommand(SimpleSubCommand $subCommand){
        self::$subCommands[] = $subCommand;
    }

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'set');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if (isset($args[0])) {
            $label = array_shift($args);
            foreach (self::$subCommands as $key => $value) {
                if ($value->checkLabel($label)) {
                    if (!$value->onCommand($sender, $args)) {
                        return true;
                    }
                    break;
                }
            }
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
            return true;
        } else {
            return false;
        }
    }
}