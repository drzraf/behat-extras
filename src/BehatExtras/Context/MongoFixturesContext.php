<?php
namespace BehatExtras\Context;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Context\ContextInterface,
    Behat\Behat\Context\ExtendedContextInterface,
    Behat\Gherkin\Node\TableNode,
    Behat\Gherkin\Node\PyStringNode;

class MongoFixturesContext extends BehatContext implements ContextInterface, MongoAwareInterface, ExtendedContextInterface
{
    protected $mongoClient;
    protected $mongoDatabase;

    private function sanityCheck()
    {
        if (!is_string($this->mongoDatabase) || !($this->mongoClient instanceof \MongoClient)) {
            throw new \RuntimeException("MongoFixtureContext has not been properly initialized. Did you turn it on in behat.yml");
        }
    }

    public function setMongoClient(\MongoClient $mongoClient)
    {
        $this->mongoClient = $mongoClient;
    }

    public function setMongoDatabase($mongoDatabase)
    {
        $this->mongoDatabase = $mongoDatabase;
    }

    /**
     * @Given /^a new "([^"]*)" document with:$/
     */
    public function aNewDocumentWith($collection, PyStringNode $string)
    {
        $database = $this->mongoDatabase;
        $obj = json_decode(trim(implode($string->getLines())), true);
        $this->mongoClient->$database->$collection->insert($obj);
    }


    /**
     * @Given /^an? "([^"]*)" collection with documents:$/
     */
    public function createDocuments($collection, TableNode $table)
    {
        $this->sanityCheck();
        foreach ($table->getHash() as $row) {
            $data = array();
            $mongoObjects = ['ObjectId(', 'Date('];
            foreach ($row as $key => $value) {
                if ($key != "_id") {
                    $value = $value === "true" ? true : $value;
                    $value = $value === "false" ? false : $value;
                    $value = is_numeric($value) ? $value + 0 : $value;
                    $value = $this->stringInArrayValues($mongoObjects, $value) === false ? $value : $this->parseMongoObjects($value);
                } else {
                    //Allow _id to be MongoIds.
                    if (substr($value, 0, 9) == "ObjectId(") {
                        $value = $this->parseMongoObjects($value);
                    }
                }

                if (strpos($key, "[]") !== false) {
                    $key = str_replace("[]", "", $key);
                    $data[$key] = explode(',', $value);
                } else if (strpos($key, ".") !== false) {
                    $keyParts = array_reverse(explode('.', $key));
                    $tempData = [];
                    for ($c = 0; $c < count($keyParts); $c++) {
                        if ($c == count($keyParts) - 1) {
                            if (isset($data[$keyParts[$c]])) {
                                $data[$keyParts[$c]] = array_merge_recursive($data[$keyParts[$c]], $tempData);
                            } else {
                                $data[$keyParts[$c]] = $tempData;
                            }
                        } else if ($c == 0) {
                            $tempData = [$keyParts[$c] => $value];
                        } else {
                            $tempData = [$keyParts[$c] => $tempData];
                        }
                    }
                } else {
                    $data[$key] = $value;
                }
            }
            $database = $this->mongoDatabase;
            $this->mongoClient->$database->$collection->insert($data);
        }
    }

    /**
     * @Given /^the mongo database is clean$/
     */
    public function dropDatabase()
    {
        $this->sanityCheck();
        $this->mongoClient->dropDB($this->mongoDatabase);
    }

    private function stringInArrayValues($haystack, $newHaystack) {
        foreach ($haystack as $searchFor) {
            if(strpos($newHaystack, $searchFor) !== false) {
                return true;
            }
        }

        return false;
    }

    private function parseMongoObjects($string) {
        //Function to parse Mongo objects to the PHP driver equivalents

        //Take off up to first paren and last paren
        $firstParenPos = strpos($string, '(');
        $objectValue = substr($string, $firstParenPos + 1);
        $objectValue = substr($objectValue, 0, -1);

        //Take off first and last ' or " if they're there.  Don't use strreplace in case of MongoRegex and MongoCode in the future
        $firstChar = substr($objectValue, 0, 1);
        $lastChar = substr($objectValue, -1, 1);
        if ($firstChar == '\'' || $firstChar == '"') {
            $objectValue = substr($objectValue, 1);
        }

        if ($lastChar == '\'' || $lastChar == '"') {
            $objectValue = substr($objectValue, 0, -1);
        }

        //Returns
        if (strpos($string, 'ObjectId(') !== false) {
            return new \MongoId((string)$objectValue);
        } else if (strpos($string, 'Date(') !== false) {
            if (is_int($objectValue)) {
                //unix timestamp
                return new \MongoDate($objectValue);
            } else {
                //try strtotime
                return new \MongoDate(strtotime($objectValue));
            }
        } else {
            return false;
        }
    }
}