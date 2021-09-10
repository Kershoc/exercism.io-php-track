<?php

declare(strict_types=1);

class Tournament
{
    public function __construct()
    {
        $this->parser = new TournamentParser();
        $this->lexer = new TournamentLexer();
        $this->formatter = new TournamentFormatter();
    }

    public function tally(string $scores): string
    {
        $this->lexer->setInput($scores);
        return $this->formatter->format($this->parser->parse($this->lexer));
    }
}

class TournamentParser
{
    private $teams;

    public function parse(TournamentLexer $lexer): TeamCollection
    {
        $this->teams = new TeamCollection();
        foreach ($lexer->getTokens() as $game) {
            $this->tallyGame($game);
        }
        return $this->teams;
    }

    private function tallyGame(GameToken $game): void
    {
        $game = new Game($this->teams->getTeam($game->homeTeam), $this->teams->getTeam($game->awayTeam), $game->outcome);
        $game->tally();
    }

}

class TournamentLexer
{
    private $input;
    public $separator = ';';
    public $gameSeparator = '\n';

    public function setInput(string $input): void
    {
        $this->input = $input;
    }
    public function getTokens()
    {
        if ($this->input === '') {
            return;
        }
        foreach (explode($this->gameSeparator, $this->input) as $line) {
            yield $this->tokenize($line);
        }
    }
    private function tokenize(string $line): GameToken
    {
        [$home, $away, $result] = explode($this->separator, $line);
        return new GameToken($home, $away, $result);
    }
}

class TournamentFormatter
{
    private const COLS = [
        'Team' => '%-30s',
        'MP' => '%2s',
        'W' => '%2s',
        'D' => '%2s',
        'L' => '%2s',
        'P' => '%2s'
    ];
    private const SEPARATOR = ' | ';
    private const EOL = '\n';

    public function format(TeamCollection $collection): string
    {
        $teams = $collection->getTeams();
        usort($teams, [TeamSorter::class, 'byScoreName']);
        $output = $this->header();
        foreach ($teams as $team) {
            $output .= $this->teamToColumns($team);
        }
        return trim($output, self::EOL);
    }
    private function header(): string
    {
        return $this->toColumns(array_keys(self::COLS));
    }
    private function toColumns(array $data): string
    {
        return sprintf(implode(self::SEPARATOR, self::COLS), ...$data) . self::EOL;
    }
    private function teamToColumns(Team $team): string
    {
        return $this->toColumns([
            $team->name,
            $team->getMatchesPlayed(),
            $team->wins,
            $team->draws,
            $team->losses,
            $team->getScore()
        ]);
    }
}
class TeamSorter
{
    public static function byScoreName(Team $a, Team $b): int
    {
        return self::byScore($a, $b) ?: self::byName($a, $b);
    }
    public static function byScore(Team $a, Team $b): int
    {
        return $b->getScore() <=> $a->getScore();
    }
    public static function byName(Team $a, Team $b): int
    {
        return $a->name <=> $b->name;
    }
}
class TeamCollection
{
    private $teams = [];

    public function getTeam(string $teamName): Team
    {
        return $this->teams[$teamName] ??= new Team($teamName);
    }

    public function getTeams(): array
    {
        return $this->teams;
    }
}
class Game
{
    public const WIN = 'win';
    public const LOSS = 'loss';
    public const DRAW = 'draw';

    public function __construct(
        private Team $home,
        private Team $away,
        private string $outcome
    ) {
    }
    public function tally(): void
    {
        if ($this->outcome === self::DRAW) {
            $this->tallyDraw();
        } elseif ($this->outcome === self::WIN) {
            $this->tallyWin($this->home, $this->away);
        } else {
            $this->tallyWin($this->away, $this->home);
        }
    }

    private function tallyDraw(): void
    {
        $this->home->addDraw();
        $this->away->addDraw();
    }

    private function tallyWin(Team $winner, Team $loser): void
    {
        $winner->addWin();
        $loser->addLoss();
    }
}

class GameToken
{
    public function __construct(
        public string $homeTeam,
        public string $awayTeam,
        public string $outcome
    ) {
    }
}

class Team
{
    private const WIN_POINTS = 3;
    public int $wins = 0;
    public int $losses = 0;
    public int $draws = 0;

    public function __construct(public string $name)
    {
    }
    public function addWin(): void
    {
        $this->wins++;
    }
    public function addLoss(): void
    {
        $this->losses++;
    }
    public function addDraw(): void
    {
        $this->draws++;
    }
    public function getScore(): int
    {
        return $this->wins * self::WIN_POINTS + $this->draws;
    }
    public function getMatchesPlayed(): int
    {
        return $this->wins + $this->losses + $this->draws;
    }
}
