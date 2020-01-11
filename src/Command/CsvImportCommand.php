<?php

namespace App\Command;

use App\Entity\ServerLog;

use League\Csv\Reader;
use League\Csv\Statement;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\DBALException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CsvImportCommand extends Command
{
	protected static $defaultName = 'app:parse';

	/**
	 * @param EntityManagerInterface $entityManager
	 */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		parent::__construct();

		$this->entityManager = $entityManager;
	}

	protected function configure()
	{
		$this
			->addOption(
				'filePath',
				null,
				InputOption::VALUE_REQUIRED,
				'Enter path to file (ie.: ./path/to/file)',
				'./src/AppBundle/Data/dataset.csv'
			)
			->setName('app:parse')
			->setDescription('Imports data from CSV file')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$filePath = $input->getOption('filePath');

		$path = $filePath;

		if (!file_exists($path))
		{
			$io->error('Could not open, file not found.');

			return 0;
		}

		if (!is_readable($path))
		{
			$io->error('Could not read, file is not accessible.');

			return 0;
		}

		$processRecord = function($row)
		{
			$duplicate = $this->entityManager->getRepository('App:ServerLog')
				->findOneBy(['id' => $row['id']]);

			if ($duplicate === null)
			{
				$serverLog = (new ServerLog())
					->setId($row['id'])
					->setTimestamp($row['timestamp'])
					->setDomainName($row['domain_name'])
					->setFilesizeBytes($row['filesize_bytes'])
					->setFilePath($row['file_path'])
					->setUserAgent($row['user_agent'])
					->setHttpResponseStatus($row['http_response_status'])
					->setHttpRequestMethod($row['http_request_method'])
					->setContentType($row['content_type']);

				$this->entityManager->persist($serverLog);
				$this->entityManager->flush();
			}

			$this->entityManager->clear();
		};

		$showMessage = function($records) use ($io)
		{
			$mem_usage = memory_get_usage(true);
			$message = 'records: '.$records.' mem: '.round($mem_usage/1048576,2).'MB';

			$io->text($message);
		};

		$keys = [
			'id',
			'timestamp',
			'domain_name',
			'filesize_bytes',
			'file_path',
			'user_agent',
			'http_response_status',
			'http_request_method',
			'content_type'
		];

		$io->title('Attempting to import data from file...');

		$reader = Reader::createFromPath($path, 'r');

		$reader->setDelimiter(' ');

		$results = (new Statement())->process($reader, $keys);

		$records = 0;
		$iterator = 0;
		$limit = 1000;

		$this->entityManager->getConnection()->beginTransaction();

		try
		{
			foreach ($results as $row)
			{
				$records++;
				$iterator++;

				$processRecord($row);

				if ($iterator === $limit)
				{
					$iterator = 0;

					$showMessage($records);
				}
			}

			$this->entityManager->getConnection()->commit();

			$io->success('Data imported successfully');
		} catch (DBALException $ex) {

			$this->entityManager->getConnection()->rollBack();

			$io->error('An error occurred while importing data');
		}

		return 0;
	}
}
