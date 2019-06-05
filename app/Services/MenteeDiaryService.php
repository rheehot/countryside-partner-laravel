<?php


namespace App\Services;

use App\Exceptions\MeteoException;
use App\Models\MenteeDiary;
use App\Traits\JwtTrait;

/**
 * Class MentorDiaryService
 * @package App\Services
 */
class MenteeDiaryService implements DiaryInterface
{
    use JwtTrait;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * @var MenteeDiary
     */
    private $menteeDiary;

    /**
     * MenteeDiaryService constructor.
     * @param MenteeDiary $menteeDiary
     * @param FileUploadService $fileUploadService
     */
    public function __construct(MenteeDiary $menteeDiary, FileUploadService $fileUploadService)
    {
        $this->menteeDiary= $menteeDiary;
        $this->fileUploadService = $fileUploadService;
    }





    /**
     * @param int $diary_srl
     * @param int $user_id
     * @return mixed
     */
    public function destroy(int $diary_srl, int $user_id): void
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param Object $formData
     * @return mixed
     */
    public function create(Object $formData)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param int $diary_srl
     * @return mixed
     */
    public function getDiary(int $diary_srl)
    {
        // TODO: Implement getDiary() method.
    }

    /**
     * @return mixed
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param int $mentee_srl
     * @return \Illuminate\Support\Collection|mixed
     */
    public function userDiary(int $mentee_srl)
    {
        
        $menteeDiaries = $this->menteeDiary->where('mentee_srl', $mentee_srl)->orderBy('regdate', 'DESC')->paginate(15);
        $collection = collect($menteeDiaries);

        $diaries = $collection->map(function ($item, $key) {
            if ($key === "data") {
                for ($i = 0; $i < count($item); $i++) {
                    $item[$i]['user_type'] = 'mentee';
                    $item[$i]['srl'] = $item[$i]['mentee_srl'];
                    $item[$i]['contents'] = str_limit($item[$i]['contents'], $limit = 200, $end = '...');
                }
            }

            return $item;
        });

        return $diaries;
    }

    /**
     * @param Object $formData
     * @param $diary_srl
     * @return mixed
     */
    public function update(Object $formData, $diary_srl): void
    {
        // TODO: Implement update() method.
    }
}