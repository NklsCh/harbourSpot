{ pkgs, config, ... }:
let
  phpPackage = pkgs.php.buildEnv {
    extraConfig = ''
      memory_limit = 256M
    '';
  };
in
{
  languages.php = {
    enable = true;
    package = phpPackage;
    fpm.pools.web = {
      settings = {
        "pm" = "dynamic";
        "pm.max_children" = 5;
        "pm.start_servers" = 2;
        "pm.min_spare_servers" = 1;
        "pm.max_spare_servers" = 5;
      };
    };
  };

  services.mysql = {
    enable = true;
    package = pkgs.mariadb;
    initialDatabases = [ { name = "harbourspot"; } ];
    ensureUsers = [
      {
        name = "root";
        password = "root";
        ensurePermissions = {
          "root.*" = "ALL PRIVILEGES";
        };
      }
    ];
  };

  services.caddy = {
    enable = true;
    virtualHosts = {
      "http://localhost:8080" = {
        extraConfig = ''
          root * public
          php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
          file_server
        '';
      };
      "http://localhost:8081" = {
        extraConfig = ''
          root * adminer
          php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
          file_server
        '';
      };
    };
  };
}
