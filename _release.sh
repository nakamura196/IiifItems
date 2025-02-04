set -e

version=1.1.1 # バージョンの例
name=IiifItems # モジュール名の例
repository_path=. # モジュールのパス（リポジトリの直下で実行する例）

# 不要なファイルを除外したモジュール名のフォルダを作成
rsync -ahv $repository_path $repository_path/$name --exclude '.*' --exclude '*.sh'

# zipファイルの作成
zip $repository_path/$name-$version.zip -r $repository_path/$name

# フォルダの削除
rm -rf $repository_path/$name

# リリース
gh release create $version $repository_path/$name-$version.zip -t $name-$version -n "Released version $version."

# ファイルの削除
rm $repository_path/$name-$version.zip