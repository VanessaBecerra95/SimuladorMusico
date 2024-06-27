<?php
require_once('conexion.php');

class ModelCRUDSimuladorMusico
{
    public function instrumentExists($instrument_name)
    {
        $query = "SELECT COUNT(*) as count FROM tbl_instrumento WHERE LOWER(VCH_NOMBRE_INSTRUMENTO) = LOWER('$instrument_name')";
        $stringConnection = Conexion::conectar();
        $result = mysqli_query($stringConnection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    public function insertInstrument($instrument_name)
    {
        $query = "INSERT INTO tbl_instrumento(VCH_NOMBRE_INSTRUMENTO) VALUES ('$instrument_name')";
        $stringConnection = Conexion::conectar();

        if (mysqli_query($stringConnection, $query)) {
            $filas = mysqli_affected_rows($stringConnection);
            if ($filas == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllInstruments()
    {
        $query = "SELECT ID_INSTRUMENTO, VCH_NOMBRE_INSTRUMENTO FROM tbl_instrumento";
        $stringConnection = Conexion::conectar();
        $result = mysqli_query($stringConnection, $query);
        $instruments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $instruments[] = $row;
        }
        return $instruments;
    }

    public function getAllMusicians()
    {
        $stringConnection = Conexion::conectar();

        $query = "SELECT RUT_MUSICO, VCH_NOMBRE_MUSICO FROM tbl_musico";
        $result = mysqli_query($stringConnection, $query);

        $musicians = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $musicians[] = $row;
        }

        mysqli_close($stringConnection);

        return $musicians;
    }

    public function musicianExistsByRut($rut)
    {
        $query = "SELECT COUNT(*) as count FROM tbl_musico WHERE RUT_MUSICO = '$rut'";
        $stringConnection = Conexion::conectar();
        $result = mysqli_query($stringConnection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    public function musicianInstrumentExists($rut, $instrument_id)
    {
        $query = "SELECT COUNT(*) as count FROM tbl_inst_musi WHERE RUT_MUSICO = '$rut' AND ID_INSTRUMENTO = '$instrument_id'";
        $stringConnection = Conexion::conectar();
        $result = mysqli_query($stringConnection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }


    public function insertMusicianWithInstrument($rut, $name, $years_experience, $instrument_id)
    {
        $stringConnection = Conexion::conectar();
        mysqli_begin_transaction($stringConnection);

        try {

            if (!$this->musicianExistsByRut($rut)) {
                $queryMusico = "INSERT INTO tbl_musico(RUT_MUSICO, VCH_NOMBRE_MUSICO) 
                                VALUES ('$rut', '$name')";
                if (!mysqli_query($stringConnection, $queryMusico)) {
                    throw new Exception("Error al insertar músico: " . mysqli_error($stringConnection));
                }
            }
            $queryInstMusi = "INSERT INTO tbl_inst_musi(ID_INSTRUMENTO, RUT_MUSICO, INT_ANOS_EXPERIENCIA) 
                              VALUES ('$instrument_id', '$rut', '$years_experience')";
            if (!mysqli_query($stringConnection, $queryInstMusi)) {
                throw new Exception("Error al insertar relación músico-instrumento: " . mysqli_error($stringConnection));
            }

            mysqli_commit($stringConnection);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($stringConnection);
            echo $e->getMessage();
            return false;
        }
    }

    public function getMusiciansByInstrument($instrument_id)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT m.VCH_NOMBRE_MUSICO, i.VCH_NOMBRE_INSTRUMENTO, im.INT_ANOS_EXPERIENCIA
                  FROM tbl_musico m
                  INNER JOIN tbl_inst_musi im ON m.RUT_MUSICO = im.RUT_MUSICO
                  INNER JOIN tbl_instrumento i ON im.ID_INSTRUMENTO = i.ID_INSTRUMENTO
                  WHERE (i.ID_INSTRUMENTO = '' OR i.ID_INSTRUMENTO = '$instrument_id')";

        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $musicos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);

        return $musicos;
    }

    public function deleteMusicianIfNoInstruments($rut)
    {
        $stringConnection = Conexion::conectar();
        $queryCheckRut = "SELECT COUNT(*) AS total FROM tbl_musico WHERE RUT_MUSICO = ?";
        $stmtCheckRut = mysqli_prepare($stringConnection, $queryCheckRut);
        mysqli_stmt_bind_param($stmtCheckRut, "s", $rut);
        mysqli_stmt_execute($stmtCheckRut);
        $resultCheckRut = mysqli_stmt_get_result($stmtCheckRut);
        $rowCheckRut = mysqli_fetch_assoc($resultCheckRut);
        $totalMusicians = $rowCheckRut['total'];
        mysqli_stmt_close($stmtCheckRut);

        if ($totalMusicians == 0) {
            return "El usuario no está registrado.";
        }
        $query = "SELECT COUNT(*) AS total FROM tbl_inst_musi WHERE RUT_MUSICO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, "s", $rut);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $totalInstruments = $row['total'];
        mysqli_stmt_close($stmt);

        if ($totalInstruments > 0) {
            return "No se puede eliminar el usuario ya que tiene un instrumento asociado.";
        }
        $queryDelete = "DELETE FROM tbl_musico WHERE RUT_MUSICO = ?";
        $stmtDelete = mysqli_prepare($stringConnection, $queryDelete);
        mysqli_stmt_bind_param($stmtDelete, "s", $rut);
        $success = mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);

        if ($success) {
            return "El usuario ha sido eliminado satisfactoriamente.";
        } else {
            return "Error al eliminar el usuario.";
        }
    }

    public function deleteInstrumentFromMusician($rut, $instrument_id)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT COUNT(*) AS num_instrumentos FROM tbl_inst_musi WHERE RUT_MUSICO = '$rut'";
        $result = mysqli_query($stringConnection, $query);
        $row = mysqli_fetch_assoc($result);
        $num_instrumentos = $row['num_instrumentos'];

        $query = "DELETE FROM tbl_inst_musi WHERE RUT_MUSICO = '$rut' AND ID_INSTRUMENTO = '$instrument_id'";
        if (mysqli_query($stringConnection, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateMusician($rut, $newName, $instrument_id, $newYearsExperience)
    {
        $stringConnection = Conexion::conectar();

        $queryUpdateName = "UPDATE tbl_musico SET VCH_NOMBRE_MUSICO = ? WHERE RUT_MUSICO = ?";
        $stmtUpdateName = mysqli_prepare($stringConnection, $queryUpdateName);
        mysqli_stmt_bind_param($stmtUpdateName, "ss", $newName, $rut);
        $successName = mysqli_stmt_execute($stmtUpdateName);
        mysqli_stmt_close($stmtUpdateName);

        $queryUpdateExperience = "UPDATE tbl_inst_musi SET INT_ANOS_EXPERIENCIA = ? WHERE RUT_MUSICO = ? AND ID_INSTRUMENTO = ?";
        $stmtUpdateExperience = mysqli_prepare($stringConnection, $queryUpdateExperience);
        mysqli_stmt_bind_param($stmtUpdateExperience, "iss", $newYearsExperience, $rut, $instrument_id);
        $successExperience = mysqli_stmt_execute($stmtUpdateExperience);
        mysqli_stmt_close($stmtUpdateExperience);

        return $successName && $successExperience;
    }

    public function getInstrumentsByMusician($rut)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT i.ID_INSTRUMENTO, i.VCH_NOMBRE_INSTRUMENTO 
              FROM tbl_inst_musi im 
              INNER JOIN tbl_instrumento i ON im.ID_INSTRUMENTO = i.ID_INSTRUMENTO 
              WHERE im.RUT_MUSICO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, 's', $rut);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $instruments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);

        return $instruments;
    }

    public function getMusicianByRut($rut)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT * FROM tbl_musico WHERE RUT_MUSICO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, 's', $rut);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $musician = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $musician;
    }

    public function musicianHasInstrument($rut, $instrument_id)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT * FROM tbl_inst_musi WHERE RUT_MUSICO = ? AND ID_INSTRUMENTO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $rut, $instrument_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $instrument = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $instrument;
    }

    public function getMusicianInstrument($rut, $instrument_id)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT * FROM tbl_inst_musi WHERE RUT_MUSICO = ? AND ID_INSTRUMENTO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $rut, $instrument_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $musicianInstrument = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $musicianInstrument;
    }

    public function getInstrumentById($id)
    {
        $stringConnection = Conexion::conectar();
        $query = "SELECT * FROM tbl_instrumento WHERE ID_INSTRUMENTO = ?";
        $stmt = mysqli_prepare($stringConnection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $instrument = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $instrument;
    }
}
